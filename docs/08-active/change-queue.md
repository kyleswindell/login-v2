# Change Queue

This queue is agent-managed and implementation-ready. It is not a scratchpad.
- Exploratory review discussion stays in chat until normalized into concise queue language.
- Active queue items use stable IDs in the format `P<phase>-<batch>-CQ-###` (e.g. `P2-F-CQ-001`).
- `In Progress` marks the queue item currently claimed by the writable `work-batch` owner.
- An unfinished `In Progress` item must be continued or explicitly reclassified before a new `Ready To Implement` item is claimed.

## Ready To Implement

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

### P2-F-CQ-011 - Usage guidance for data display, navigation, overlays, loading, inputs, breadcrumb, structured list, file uploader, date picker, grid, and tile
- Status: Ready To Implement
- Owner: Batch F
- Scope: Establish UI Reference guidance for all areas identified in the Carbon audit coverage passes (pass 2 and pass 3). Pass 2 areas: data table variants and table loading rules; pagination variant selection; tabs variant and behavior selection; modal variant, focus-trap, and modal-vs-page requirements; tooltip vs toggletip and definition-tooltip guidance; loading indicator vs skeleton selection; full-page vs inline loading; search scope placement; search vs filter distinction; input style and warning-state guidance; overflow menu thresholds and destructive action placement. Pass 3 areas: breadcrumb vs progress indicator selection; breadcrumb overflow/truncation; structured list vs data table selection; selectable structured list vs radio group; file uploader variant selection; file uploader size pairing with form fields; date picker variant selection; date format display and locale guidance; gutter mode selection for page layout; grid style model for Login App 2.0; tile variant selection; tile vs card distinction. All 32 gaps from pass 2 and pass 3 route to this item: G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02, G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02.
- Acceptance:
  - data table variant selection rule (basic/selectable/expandable) is documented (G-TABLE-01)
  - inline icon button vs overflow menu threshold rule is explicit (G-TABLE-02, G-OVERFLOW-01)
  - table skeleton loading guidance is documented (G-TABLE-03)
  - pagination vs pagination-nav variant selection rule is documented (G-PAGIN-01)
  - pagination page-size options and placement guidance is explicit (G-PAGIN-02)
  - line vs contained vs vertical tab variant selection rule is documented (G-TABS-01)
  - automatic vs manual tablist behavior is documented (G-TABS-02)
  - modal variant selection rule (passive/transactional/danger/acknowledgment/progress) is documented (G-MODAL-01)
  - focus-trap accessibility requirement for modals is documented (G-MODAL-02)
  - modal vs dedicated page or side panel selection rule is documented (G-MODAL-03)
  - tooltip vs toggletip usage boundary is explicit (G-TOOLTIP-01)
  - definition tooltip guidance is documented (G-TOOLTIP-02)
  - loading spinner vs skeleton selection rule is documented (G-LOAD-01)
  - full-page overlay vs inline loading selection is documented (G-LOAD-02)
  - search scope (global/page/component) placement guidance is explicit (G-SEARCH-01)
  - search vs filter pattern distinction is documented (G-SEARCH-02)
  - default vs fluid input styling choice is documented (G-INPUT-01)
  - input warning state guidance is documented (G-INPUT-02)
  - overflow menu destructive action placement rule is documented (G-OVERFLOW-02)
  - breadcrumb vs progress indicator selection rule is documented (G-BREADCRUMB-01)
  - breadcrumb overflow/truncation behavior is documented (G-BREADCRUMB-02)
  - structured list vs data table selection rule is documented (G-STRLIST-01)
  - selectable structured list vs radio group boundary is documented (G-STRLIST-02)
  - file uploader variant selection rule (button vs drag-and-drop) is documented (G-FILEUP-01)
  - file uploader size pairing with form fields is documented (G-FILEUP-02)
  - date picker variant selection rule (simple vs calendar vs time) is documented (G-DATEPICK-01)
  - date format display and locale guidance is documented (G-DATEPICK-02)
  - gutter mode selection rule for page layout contexts is documented (G-GRID-01)
  - grid style model for Login App 2.0 is documented (G-GRID-02)
  - tile variant selection rule (base/clickable/selectable/expandable) is documented (G-TILE-01)
  - tile vs card distinction is documented (G-TILE-02)

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
- Scope: Fifth correction pass (queue wording cleanup) complete. Queue state inconsistency resolved. P2-F-CQ-011 contract expanded and corrected to cover all 15 gap series and all 32 routed gaps. review.md Pass Summary synced. Dates corrected.
- Acceptance:
  - P2-F-CQ-001 appears in exactly one queue section (this one)
  - P2-F-CQ-011 scope and acceptance explicitly cover all 15 gap series: G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02, G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02
  - review.md Pass Summary reflects all five correction passes and current state
  - all worklog and index dates are 2026-06-03
  - gap count is 62 across 22 areas consistently
  - P2-F-CQ-008 remains button variant and action label guidance only
  - P2-F-CQ-011 queue wording matches the audit gap definitions
- Implemented in: worklog-2-F-0002 (initial); worklog-2-F-0003 (correction pass 1); worklog-2-F-0004 (correction pass 2 — depth); worklog-2-F-0005 (correction pass 3 — missing areas + evidence fix); worklog-2-F-0006 (correction pass 4 — queue state reconciliation); worklog-2-F-0007 (correction pass 5 — queue wording cleanup)

## Blocked

## Deferred

## Passed Review

## Closed

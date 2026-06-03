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
- Scope: Audit the current UI Reference against Carbon-style design-system completeness and produce the authoritative starter catalog matrix before implementation continues.
- Acceptance:
  - audit source set includes Carbon documentation site, `carbon-design-system/carbon-website`, `carbon-design-system/carbon`, and `carbon/tree/main/docs`
  - audit covers actions, buttons, forms, alerts, toasts, notifications, status indicators, badges, selection controls, and starter-page organization
  - starter catalog matrix maps each required starter to intended use, shell family, Tier 2 patterns, required states, UI Reference route, live proof surface, and owning queue item
  - gaps are normalized into queue language instead of staying as exploratory notes

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

### P2-F-CQ-008 - Usage guidance standards for actions and feedback
- Status: Ready To Implement
- Owner: Batch F
- Scope: Establish UI Reference guidance for badge, alert, toast, notification, button, action-label, form-action, AJAX alert, status indicator, and selection-option usage.
- Acceptance:
  - badge, alert, toast, notification, and status color semantics are explicit
  - standard, soft, ghost, outline, and destructive button usage rules are explicit
  - form action labels distinguish apply/stay-on-page behavior from submit/complete/return behavior
  - inline validation, on-page AJAX alerts, toasts, and persisted notifications have clear usage boundaries
  - same-page AJAX feedback does not imply a full page refresh unless explicitly documented

### P2-F-CQ-006 - Batch F docs, tests, and handoff readiness
- Status: Ready To Implement
- Owner: Batch F
- Scope: Add automated coverage and synchronize planning/handoff notes after starter implementation.
- Acceptance:
  - tests verify starter routes and required markers
  - Phase 2 docs reflect Batch F implementation status
  - Batch E remains the post-F close-out path and staging deploy remains out of scope

## In Progress

## Implemented Pending Review

## Blocked

## Deferred

## Passed Review

## Closed

# Change Queue

This queue is agent-managed and implementation-ready. It is not a scratchpad.
- Exploratory review discussion stays in chat until normalized into concise queue language.
- Active queue items use stable IDs in the format `P<phase>-<batch>-CQ-###` (e.g. `P2-F-CQ-001`).
- `In Progress` marks the queue item currently claimed by the writable `work-batch` owner.
- An unfinished `In Progress` item must be continued or explicitly reclassified before a new `Ready To Implement` item is claimed.

## Ready To Implement

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

### P2-F-CQ-006 - Batch F docs, tests, and handoff readiness
- Status: Ready To Implement
- Owner: Batch F
- Scope: Add automated coverage and synchronize planning/handoff notes after starter implementation.
- Acceptance:
  - tests verify starter routes and required markers
  - Phase 2 docs reflect Batch F implementation status
  - Batch E remains the post-F close-out path and staging deploy remains out of scope

### P2-F-CQ-008 - Usage guidance standards for button variants and action labels
- Status: Ready To Implement
- Owner: Batch F
- Scope: Rework the current note-only button/action guidance into concrete, referenceable T1 and T2 UI Reference examples. The page must reduce implementation guesswork for later development by showing valid component usage, variants, states, and action-label patterns in context.
- Review Finding:
  - Manual review rejected the current implementation because the T1/T2 pages mostly list G-* notes above existing examples instead of providing valid reference examples for component types, variants, states, and implementation usage.
- Acceptance:
  - T1 button examples show standard, soft, ghost, outline, and destructive usage as concrete component examples, not only explanatory notes (G-ACT-01–05)
  - action examples include default, focus, disabled, loading, icon-leading, icon-only, destructive, and grouped-menu states where supported by existing components
  - T2 action examples show page-header actions, form actions, table/list row actions, and grouped overflow actions using the same rules
  - action-label examples distinguish apply/stay-on-page behavior from submit/complete/return behavior in concrete form/filter/page contexts (G-LABEL-01–06)
  - implementation guidance identifies the component names, supported props/variants/semantics, required wrapper patterns, and owner routes for reuse
  - per-page "one primary action" rule is visible in examples and documented

### P2-F-CQ-010 - Usage guidance for form field standards and selection controls
- Status: Ready To Implement
- Owner: Batch F
- Scope: Rework the current note-only form/selection guidance into concrete, referenceable T1 and T2 UI Reference examples for fields, field states, validation, and selection controls.
- Review Finding:
  - Manual review rejected the current implementation because it documents rules but does not provide enough component examples and implementation guidance to minimize later developer guesswork.
- Acceptance:
  - T1 examples show required, optional, helper, error, warning, disabled, read-only, focused, textarea, select, date, date-time, file, checkbox, radio, toggle, searchable select/combo, and multi-select guidance using existing components or clearly marked queued gaps
  - T2 form examples show field groups, form sections, inline rows, validation summary, form action bar, settings-style forms, and compact account/profile form usage
  - required vs optional field marking policy is demonstrated in examples, not only documented (G-FORM-01–04)
  - checkbox vs radio vs toggle selection boundary is demonstrated with concrete examples (G-SEL-01–03)
  - select vs combo box vs multi-select selection rule is demonstrated with component usage guidance
  - implementation guidance identifies component names, supported props/attributes, required classes/wrappers, validation placement, and owner routes for reuse

### P2-F-CQ-009 - Usage guidance for notifications, badges, and feedback
- Status: Ready To Implement
- Owner: Batch F
- Scope: Rework the current note-only notification/badge/feedback guidance into concrete, referenceable T1 and T2 UI Reference examples for badges, statuses, inline alerts, toasts, banners/callouts, persisted notifications, and AJAX feedback.
- Review Finding:
  - Manual review rejected the current implementation because it documents rules but does not provide enough referenceable examples for component types, variants, and usage/implementation expectations.
- Acceptance:
  - badge/status examples show semantic mappings, base/outline variants, icon/no-icon states, table/list context, and text-first status usage (G-BADGE-01–04)
  - feedback examples show inline alert, toast, callout/banner, page-level alert, persisted notification, and AJAX same-page feedback boundaries as concrete examples (G-NOTIF-01–05)
  - stacking and placement examples demonstrate multi-toast behavior and inline-vs-page placement without adding unrelated runtime notification features
  - T2 examples show form validation feedback, table/list feedback, dashboard/page feedback, and notification-center handoff expectations
  - implementation guidance identifies component names, supported semantics/variants, live-region expectations, wrapper/data attributes, and owner routes for reuse
  - guidance remains Login App 2.0-specific and does not adopt Carbon visual tokens

### P2-F-CQ-011 - Usage guidance for data display, navigation, overlays, loading, inputs, breadcrumb, structured list, file uploader, date picker, grid, and tile
- Status: Ready To Implement
- Owner: Batch F
- Scope: Rework the current note-only broader guidance into concrete, referenceable T1 and T2 UI Reference examples across the routed pass 2/pass 3 component and pattern families.
- Review Finding:
  - Manual review rejected the current implementation because all 32 G-* gaps are represented mostly as notes/matrices, not as referenceable component/pattern examples with variants, states, and implementation guidance.
- Acceptance:
  - table, pagination, tabs, modal, tooltip/toggletip, loading, search/filter, input, overflow, breadcrumb, structured-list, file-uploader, date-picker, grid, and tile guidance is demonstrated through concrete examples where existing components/patterns exist
  - examples cover the documented variants and states for all 32 routed gaps: G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02, G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02
  - missing component families are clearly identified as queued gaps instead of implied as implemented
  - T1 pages show component primitives and supported variants/states; T2 pages show real pattern compositions and usage boundaries
  - implementation guidance identifies component names, data attributes, wrappers, route ownership, and expected usage boundaries for reuse
  - examples preserve Login App 2.0 visual direction and do not introduce Carbon visual tokens

## In Progress

<!-- none -->

## Implemented Pending Review

### P2-F-CQ-012 - UI control module ownership cleanup
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-010, P2-F-CQ-011
- Scope: Split `resources/js/ui-controls.js` into smaller control-family modules only where it supports Batch F form, selection, table/search, dropdown, and filter guidance work. Keep runtime behavior unchanged and keep `resources/js/app.js` as the lifecycle registration entry point.
- Acceptance:
  - control behavior is grouped by concern rather than one mixed module for all controls
  - lifecycle registration remains centralized and readable from `resources/js/app.js`
  - selectors, UI behavior, route behavior, and rendered markup contracts remain unchanged
  - no notification feature expansion or unrelated shell behavior is introduced
  - `npm run build` passes
  - focused UI Reference tests pass for touched control surfaces
- Implemented in: worklog-2-F-0009

### P2-F-CQ-013 - UI CSS ownership map and first safe extraction boundary
- Status: Implemented Pending Review
- Owner: Batch F
- Follow-up To: P2-F-CQ-008, P2-F-CQ-009, P2-F-CQ-010, P2-F-CQ-011
- Scope: Turn the `resources/css/app.css` read map into concrete UI-standardization ownership sections for Batch F. If a low-risk boundary is clear, extract one cohesive UI section into an imported CSS module without changing visual tokens or behavior.
- Acceptance:
  - CSS ownership/read map identifies action/button, form/control, table/data, notification/feedback, dashboard/widget, theme-token, and compatibility-override sections
  - nearest agent guidance points future UI work to targeted CSS sections instead of broad stylesheet reads
  - any extraction keeps Tailwind/Vite build behavior stable
  - no new color, spacing, radius, typography, or component variants are introduced
  - `npm run build` passes
  - focused UI Reference tests pass for touched surfaces
- Implemented in: worklog-2-F-0010

## Blocked

## Deferred

### P2-F-CQ-014 - SettingsController settings-update extraction
- Status: Deferred
- Owner: Future platform architecture cleanup
- Scope: Repeated validation/write/logging patterns in `SettingsController` are a SOLID cleanup candidate, but this is backend settings architecture rather than Batch F UI element standardization.
- Revisit When: P2-F-CQ-003 exposes a settings starter blocker that requires backend refactoring, or a later platform architecture cleanup batch owns settings update flow extraction.

### P2-F-CQ-015 - Realtime notification transport/rendering split
- Status: Deferred
- Owner: Future notifications architecture cleanup
- Scope: `resources/js/realtime-notifications.js` can later split transport setup from notification rendering and local read-state updates, but notifications feature expansion is out of Batch F scope.
- Revisit When: P2-F-CQ-009 requires runtime notification behavior changes, or a later notifications batch owns realtime client behavior.

## Passed Review

### P2-F-CQ-001 - Carbon contrast audit and starter catalog matrix
- Status: Passed Review
- Owner: Batch F
- Scope: Fifth correction pass (queue wording cleanup) complete. Queue state inconsistency resolved. P2-F-CQ-011 contract expanded and corrected to cover all 15 gap series and all 32 routed gaps. review.md Pass Summary synced. Dates corrected.
- Acceptance:
  - P2-F-CQ-001 appears in exactly one queue section
  - P2-F-CQ-011 scope and acceptance explicitly cover all 15 gap series: G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02, G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02
  - review.md Pass Summary reflects all five correction passes and current state
  - all worklog and index dates are 2026-06-03
  - gap count is 62 across 22 areas consistently
  - P2-F-CQ-008 remains button variant and action label guidance only
  - P2-F-CQ-011 queue wording matches the audit gap definitions
- Implemented in: worklog-2-F-0002 (initial); worklog-2-F-0003 (correction pass 1); worklog-2-F-0004 (correction pass 2 — depth); worklog-2-F-0005 (correction pass 3 — missing areas + evidence fix); worklog-2-F-0006 (correction pass 4 — queue state reconciliation); worklog-2-F-0007 (correction pass 5 — queue wording cleanup)
- Review result: Approved on 2026-06-03

### P2-F-CQ-007 - UI Reference starter catalog entry point
- Status: Passed Review
- Owner: Batch F
- Scope: Added `/platform/ui-reference/patterns/starters` as the discoverable starter catalog entry point, registered sidebar navigation, documented route disposition, and added focused route coverage.
- Acceptance:
  - starter catalog entry is visible from UI Reference navigation
  - route and tests identify starter examples intentionally
  - starter catalog lists all 14 required starter examples with owner CQ, target route, required states, and primary patterns
  - route disposition matrix identifies keep/update/add/support-route decisions for current UI Reference routes
- Implemented in: worklog-2-F-0008
- Review result: Approved on 2026-06-03

## Closed

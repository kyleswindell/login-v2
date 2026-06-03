# Checklist

## Batch Initialization
- [x] Batch Initialization
  Status: implemented
  - Batch F planning source exists
  - active workspace points to Phase 2 Batch F
  - Batch E close-out is paused until Batch F exits
  - staging deploy remains out of scope

## UI Reference Starter Catalog
- [ ] UI Reference Starter Catalog
  Status: implemented (pending review) — Carbon audit correction pass 5 (queue wording cleanup) complete (worklog-2-F-0007): P2-F-CQ-001 remains review-ready; duplicate queue heading removed; P2-F-CQ-011 contract corrected to cover all 15 gap series and 32 routed gaps with audit-aligned acceptance wording; worklog dates remain corrected; 62 gaps across 22 areas consistent throughout; concrete starters and navigation entry point remain in P2-F-CQ-002 through P2-F-CQ-007
  - [x] Carbon contrast audit is complete
  - [x] audit source set includes Carbon documentation site, Carbon website source repo, Carbon main repo, and Carbon main docs directory
  - [x] audit treats Carbon as a completeness benchmark, not a visual adoption target
  - [x] authoritative starter catalog matrix is documented
  - [ ] required starter examples are visible and locatable in UI Reference
  - [ ] UI Reference navigation exposes the starter catalog intentionally
  - [ ] starter examples are concrete page compositions, not only rule summaries

## Design-System Usage Guidance
- [ ] Design-System Usage Guidance
  Status: not implemented
  - badge, alert, toast, notification, and status color semantics are explicit
  - guidance preserves the existing Login App 2.0 visual direction
  - standard, soft, ghost, outline, and destructive button usage rules are explicit
  - common action labels and action hierarchy are documented
  - form action labels distinguish apply/stay-on-page from submit/complete/return behavior
  - inline validation, page-level AJAX alerts, toasts, and persisted notifications have clear usage boundaries
  - same-page AJAX feedback does not imply a full page refresh unless explicitly documented
  - required and optional field marker rules are documented
  - selection option variants and usage rules are documented
  - required classes, ready-to-use components, component sets, and starter views are identified or queued

## Module Home And Dashboard Summary Starters
- [ ] Module Home And Dashboard Summary Starters
  Status: not implemented
  - module home / overview starter is reviewable
  - dashboard/module summary starter uses widget-shell and stat-card conventions
  - dashboard widget examples by module content type are reviewable
  - empty or next-action state is represented where applicable

## Settings And Setup Starters
- [ ] Settings And Setup Starters
  Status: not implemented
  - settings starter demonstrates title/actions, settings navigation, form sections, validation, and form actions
  - setup/configuration starter demonstrates task-oriented setup framing, setup navigation, registration/config sections, and action placement
  - current setup/settings proof surfaces are normalized only where needed for starter parity

## Account/Profile Starters
- [ ] Account/Profile Starters
  Status: not implemented
  - account/profile read-only starter demonstrates identity summary and key-value detail
  - account/profile editable starter demonstrates settings-style form scaffolding
  - `/account`, `/account/settings`, and `/account/preferences` remain feature-behavior stable

## List, Detail, And Form Starters
- [ ] List, Detail, And Form Starters
  Status: not implemented
  - list/index starter demonstrates page title/actions, search/filter, table or list content, and empty state
  - table-management index starter demonstrates filters, row actions, and empty/bulk-action posture where applicable
  - operational log/detail starter demonstrates diagnostic read-only hierarchy
  - content browser/split-view starter demonstrates list/detail browsing structure
  - detail/read-only starter demonstrates section blocks, key-value detail, and action placement
  - create/edit form starter demonstrates form sections, validation summary, field grouping, and form actions
  - blocked/empty/unavailable state starter demonstrates permission-blocked, no-data, and unavailable patterns without feature-specific behavior

## Automated Coverage
- [ ] Automated Coverage
  Status: not implemented
  - route tests confirm starter examples are reachable
  - assertions confirm required starter labels and pattern markers are present
  - no staging deploy validation is required in this batch

## Handoff Readiness
- [ ] Handoff Readiness
  Status: not implemented
  - Phase 3 and Phase 4 can consume the starter catalog without reopening Phase 2 UI decisions
  - Batch E entry gates remain blocked until Batch F is complete
  - final Batch F state is explicit before close-out resumes

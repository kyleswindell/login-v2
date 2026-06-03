# Review

## Status
PARTIAL

## Issues

**P2-F-CQ-001 review failure (worklog-2-F-0002):**
1. GitHub source set not directly evidenced — audit findings doc claimed carbondesignsystem.com "aggregates" the required GitHub repos but never directly inspected those repos
2. Starter catalog matrix introduced `loading skeleton` in Module Home required states — implies unplanned Skeleton Loader Tier 2 implementation that is not locked
3. `worklog-2-F-0002` contains stale `Commit: pending` status (artifacts were already committed in that same pass)

**P2-F-CQ-001 second review failure (worklog-2-F-0003):**
1. Audit does not map public doc pages to corresponding GitHub MDX source paths — confirmation of repo-root relationship is not sufficient; concrete file-level mapping required
2. Inspection limited to repo roots, READMEs, package lists, and directory listings — no actual source files, examples, stories, or package docs inspected
3. Claim "no supplemental consumer usage guidance found" is too strong without having inspected package-level READMEs, Storybook stories, or component examples
4. Audit covers too narrow an area set — missing data table, pagination, tabs, modal, tooltip, loading/progress, search, combo box, multi-select, overflow menu, breadcrumbs, structured list, file uploader, date picker, layout/grid, tile/card
5. All 27 design-system usage guidance gaps routed to single P2-F-CQ-008 item — scope may be too broad for clean implementation
6. Some starter matrix proof surfaces are "closest analog" or weak placeholders — not verified as real UI routes

**P2-F-CQ-001 third review failure (worklog-2-F-0004):**
1. Six required coverage areas still missing after the second correction pass: breadcrumbs, structured list, file uploader, date picker, layout/grid, tile/card — all identified in the second review failure as required and not yet added
2. Carbon main repo evidence still overclaims — claim "no supplemental consumer usage documentation exists at the file level" was based only on a directory listing of `packages/react/src/components/`; no actual component source files, package READMEs, examples, or stories were opened and inspected; the statement is not defensible at that depth
3. Gap count is internally inconsistent — acceptance proof table states "47 gaps across 16 areas"; the routing summary table has 50 rows; worklog-2-F-0004 mentions 50 total gaps; the inconsistency was not resolved
4. Skeleton Loader follow-up incorrectly routed to P2-F-CQ-008 in Starter Catalog Matrix Note 6 — P2-F-CQ-008 is now button/action-label only; loading/skeleton guidance belongs in P2-F-CQ-011
5. review.md not updated to reflect third failure state, new queue items P2-F-CQ-009/010/011, or corrected remaining queue list

## Required Fixes

- Add audit sections for the six missing areas (breadcrumbs, structured list, file uploader, date picker, layout/grid, tile/card) with Login App 2.0-specific gaps and queue routing
- Fix Carbon main repo evidence: either inspect a concrete file (e.g., `packages/react/README.md` or a component package README) and document the path, or soften the claim to match what was actually inspected
- Recount all gaps after adding the new areas and make the count consistent across: acceptance table, routing summary, worklog, and notes
- Update Starter Catalog Matrix Note 6 to route Skeleton Loader follow-up to P2-F-CQ-011 instead of P2-F-CQ-008
- Update review.md to reflect current state (this document)

## Manual Review

Visual: not started
Functional: not started

## Pass Summary

**P2-F-CQ-001 — Returned to Ready To Implement (third review failure; worklog-2-F-0004)**
- Third review failure: six coverage areas missing; Carbon main repo claim overstated; gap count inconsistent; skeleton loader routed incorrectly; review.md stale
- Five specific issues identified; item reclassified for third correction pass

**Remaining queue items — not yet started:**
- P2-F-CQ-007 — UI Reference starter catalog entry point
- P2-F-CQ-002 — Module home and dashboard summary starters
- P2-F-CQ-003 — Settings and setup starters
- P2-F-CQ-004 — Account/profile starters
- P2-F-CQ-005 — List, detail, and create/edit starters
- P2-F-CQ-008 — Usage guidance standards for button variants and action labels
- P2-F-CQ-009 — Usage guidance for notifications, badges, and feedback
- P2-F-CQ-010 — Usage guidance for form field standards and selection controls
- P2-F-CQ-011 — Usage guidance for data display, navigation, overlays, loading, and inputs
- P2-F-CQ-006 — Batch F docs, tests, and handoff readiness

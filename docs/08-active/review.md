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

**P2-F-CQ-001 fourth review failure (worklog-2-F-0005):**
1. Active batch queue state is inconsistent — P2-F-CQ-001 appears in both the "Ready To Implement" section and the "Implemented Pending Review" section of change-queue.md simultaneously; this means the claim/completion cycle did not fully clean up the Ready To Implement entry when moving through In Progress
2. P2-F-CQ-011 scope and acceptance do not include the 12 new gaps routed to it in correction pass 3 — G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02 are documented in the audit findings and assigned to P2-F-CQ-011 in the routing summary, but P2-F-CQ-011's queue entry only lists the original 9 series (G-TABLE through G-OVERFLOW) and has no acceptance criteria for the 6 new areas
3. review.md Pass Summary reflects only "Returned to Ready To Implement (third review failure)" and does not record correction pass 3 completing or P2-F-CQ-001 returning to Implemented Pending Review
4. worklog-2-F-0005 and its worklogs/index.md entry are future-dated 2026-06-05; current date is 2026-06-03; worklog-2-F-0003 index entry is also dated 2026-06-05

## Required Fixes

- Fix change-queue.md queue state: P2-F-CQ-001 must appear in exactly one section; remove duplicate; return it to Ready To Implement under the current correction pass scope
- Update P2-F-CQ-011 scope and acceptance to include all 15 gap series routed to it: G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02, G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02
- Correct future dates in worklog-2-F-0005 and worklogs/index.md (2026-06-05 → 2026-06-03); correct 2-F-0003 index entry date (2026-06-05 → 2026-06-03)
- Sync review.md Pass Summary to reflect correction pass 3 completed and P2-F-CQ-001 in Implemented Pending Review

## Manual Review

Visual: not started
Functional: not started

## Pass Summary

**P2-F-CQ-001 — Returned to Ready To Implement (third review failure; worklog-2-F-0004)**
- Third review failure: six coverage areas missing; Carbon main repo claim overstated; gap count inconsistent; skeleton loader routed incorrectly; review.md stale
- Five specific issues identified; item reclassified for third correction pass

**P2-F-CQ-001 — Returned to Implemented Pending Review (correction pass 3; worklog-2-F-0005)**
- Six new coverage areas added (§17–22: breadcrumb, structured list, file uploader, date picker, layout/grid, tile); 12 new gaps documented; gap count corrected to 62 across 22 areas; Carbon main repo evidence softened; skeleton loader routing fixed in matrix; review.md synced
- Returned to Implemented Pending Review after correction pass 3

**P2-F-CQ-001 — Returned to Ready To Implement (fourth review failure; worklog-2-F-0005)**
- Fourth review failure: active batch queue state inconsistent (P2-F-CQ-001 in both Ready To Implement and Implemented Pending Review simultaneously); P2-F-CQ-011 queue contract missing 12 new gaps from pass 3; review.md Pass Summary did not reflect correction pass 3 completion; worklog-2-F-0005 and index entries future-dated 2026-06-05
- Four specific issues identified; item reclassified for fourth correction pass

**P2-F-CQ-001 — Returned to Implemented Pending Review (correction pass 4; worklog-2-F-0006)**
- Queue state inconsistency resolved (P2-F-CQ-001 now appears in exactly one section); P2-F-CQ-011 queue contract expanded to include all 15 gap series (G-TABLE-01–03 through G-TILE-01–02); review.md Pass Summary synced; dates corrected in worklog-2-F-0005 and index entries (2026-06-05 → 2026-06-03)
- P2-F-CQ-001 returned to Implemented Pending Review after correction pass 4

**Remaining queue items — Ready To Implement:**
- P2-F-CQ-007 — UI Reference starter catalog entry point
- P2-F-CQ-002 — Module home and dashboard summary starters
- P2-F-CQ-003 — Settings and setup starters
- P2-F-CQ-004 — Account/profile starters
- P2-F-CQ-005 — List, detail, and create/edit starters
- P2-F-CQ-008 — Usage guidance standards for button variants and action labels
- P2-F-CQ-009 — Usage guidance for notifications, badges, and feedback
- P2-F-CQ-010 — Usage guidance for form field standards and selection controls
- P2-F-CQ-011 — Usage guidance for data display, navigation, overlays, loading, inputs, breadcrumb, structured list, file uploader, date picker, grid, and tile
- P2-F-CQ-006 — Batch F docs, tests, and handoff readiness

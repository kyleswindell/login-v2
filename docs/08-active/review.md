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

**P2-F-CQ-001 fifth review cleanup (worklog-2-F-0006):**
1. `change-queue.md` contains a duplicate `P2-F-CQ-007` heading.
2. P2-F-CQ-011 is described as owning 30 routed gaps, but pass 2 plus pass 3 route 32 gaps to it.
3. Several P2-F-CQ-011 acceptance bullets drift from the audit gap definitions: G-TABLE-03, G-TABS-02, G-MODAL-03, G-TOOLTIP-02, G-LOAD-02, G-SEARCH-02, and G-INPUT-02 need exact acceptance wording.

## Required Fixes

- No open P2-F-CQ-001 required fixes after worklog-2-F-0007.
- Remaining Batch F work should continue with the Ready To Implement items listed below.

## Manual Review

Visual: PARTIAL
Functional: PARTIAL

- P2-F-CQ-001: PASS — docs/audit review approved; no visual surface required.
- P2-F-CQ-007: PASS — starter catalog route and navigation approved; focused route test passed.
- Remaining Batch F items still require implementation before final visual/functional batch review.

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

**P2-F-CQ-001 — Returned to Implemented Pending Review (correction pass 5; worklog-2-F-0007)**
- Final queue wording cleanup complete: duplicate P2-F-CQ-007 heading removed; P2-F-CQ-011 routed-gap count corrected to 32; P2-F-CQ-011 acceptance wording aligned to the audit definitions; notes/checklist/worklogs synced.
- P2-F-CQ-001 remains Implemented Pending Review after correction pass 5

**P2-F-CQ-007 — Returned to Implemented Pending Review (starter catalog entry point; worklog-2-F-0008)**
- Added `/platform/ui-reference/patterns/starters`, sidebar navigation, starter ownership mapping, and the route disposition matrix.
- Focused starter catalog route test passed; full UI Reference test file still has an unrelated widget-content assertion failure.

**P2-F-CQ-001 — Passed Review (2026-06-03)**
- Approved as the Batch F audit and starter catalog matrix source. Findings are sufficiently broad, queue routing is coherent, and no open scoped fixes remain for this item.

**P2-F-CQ-007 — Passed Review (2026-06-03)**
- Approved as the UI Reference starter catalog entry point. The route is discoverable from UI Reference navigation, lists all 14 starters with owner routing, and includes route disposition guidance for existing UI Reference views.

**Remaining queue items — Ready To Implement:**
- P2-F-CQ-002 — Module home and dashboard summary starters
- P2-F-CQ-003 — Settings and setup starters
- P2-F-CQ-004 — Account/profile starters
- P2-F-CQ-005 — List, detail, and create/edit starters
- P2-F-CQ-008 — Usage guidance standards for button variants and action labels
- P2-F-CQ-009 — Usage guidance for notifications, badges, and feedback
- P2-F-CQ-010 — Usage guidance for form field standards and selection controls
- P2-F-CQ-011 — Usage guidance for data display, navigation, overlays, loading, inputs, breadcrumb, structured list, file uploader, date picker, grid, and tile
- P2-F-CQ-006 — Batch F docs, tests, and handoff readiness

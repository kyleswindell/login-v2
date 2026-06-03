# Worklog 2-F-0004

**Batch:** Phase 2 – Implementation Batch F
**Pass:** Correction pass 2 — depth
**Queue Item:** P2-F-CQ-001 (Carbon contrast audit and starter catalog matrix)
**Date:** 2026-06-03
**Status:** READY_FOR_REVIEW

---

## Scope

Second correction pass for P2-F-CQ-001. The second review failure identified that the audit was too shallow for Phase 2 purpose:
- Public doc pages were not mapped to their GitHub MDX source paths
- Source inspection was limited to repo roots and READMEs only
- Coverage was too narrow — missing data table, pagination, tabs, modal, tooltip, loading, search, dropdown/multiselect/combo box, overflow menu, and related patterns
- All 27 usage guidance gaps were routed to a single P2-F-CQ-008 (too broad)
- Some starter matrix proof surfaces were weak or secondary-analog only

---

## Work Performed

### 1. MDX Source Path Mapping

Fetched directory listings from `github.com/carbon-design-system/carbon-website` for:
- `src/pages/components/button/` → confirmed: `usage.mdx`, `style.mdx`, `code.mdx`, `accessibility.mdx`, `images/`
- `src/pages/components/notification/` → confirmed: same pattern
- `src/pages/patterns/` → confirmed: 17 named subdirectories (`common-actions/`, `dialog-pattern/`, `empty-states-pattern/`, `filtering/`, `forms-pattern/`, `global-header/`, `loading-pattern/`, `login-pattern/`, `notification-pattern/`, `overflow-content/`, `read-only-states-pattern/`, `search-pattern/`, `status-indicator-pattern/`, etc.)

Each of the 17 public carbondesignsystem.com pages used in this audit has been mapped to its corresponding `carbon-website` MDX source path. The mapping table was added to Audit Method §2 in the findings document.

**Key finding:** MDX files are named `usage.mdx`, `style.mdx`, `code.mdx`, `accessibility.mdx` — NOT `index.mdx` as previously hypothesized. The public site IS the compiled output of these files; no supplemental consumer guidance exists outside what is published.

### 2. Deeper Carbon Main Repository Inspection

Fetched `packages/react/src/components/` directory listing from `github.com/carbon-design-system/carbon`. Confirmed:
- Component subdirectories contain TypeScript/SCSS implementation source only
- No consumer-facing usage documentation MDX or README files exist at the component subfolder level
- README redirects consumers to carbondesignsystem.com for all usage guidance

This resolves the review failure flagging "no supplemental consumer guidance" as too strong a claim — the deeper inspection confirms the claim holds. Updated Audit Method §3 in the findings document.

### 3. Expanded Coverage Audit — 9 Additional Component Areas

Fetched and audited the following carbondesignsystem.com pages not covered in prior passes:
- `data-table/usage/` → added §8 with gaps G-TABLE-01–03
- `pagination/usage/` → added §9 with gaps G-PAGIN-01–02
- `tabs/usage/` → added §10 with gaps G-TABS-01–02
- `modal/usage/` → added §11 with gaps G-MODAL-01–03
- `tooltip/usage/` → added §12 with gaps G-TOOLTIP-01–02
- `loading/usage/` → added §13 with gaps G-LOAD-01–02
- `search/usage/` → added §14 with gaps G-SEARCH-01–02
- `dropdown/usage/` (covers dropdown, multiselect, combo box) → added §15 with gaps G-INPUT-01–02
- `overflow-menu/usage/` → added §16 with gaps G-OVERFLOW-01–02

Total new gaps documented: 20 across 9 areas. Total gap count across audit: 50 gaps.

### 4. Gap-to-Queue Routing Split

The original routing had all 27 usage guidance gaps routed to P2-F-CQ-008. After expanded coverage and review, the routing was split:
- **P2-F-CQ-008** (narrowed): button variant and action label guidance only — G-ACT-01–05, G-LABEL-01–06 (11 gaps)
- **P2-F-CQ-009** (new): notification, badge, and feedback guidance — G-NOTIF-01–05, G-BADGE-01–04 (9 gaps)
- **P2-F-CQ-010** (new): form field standards and selection control guidance — G-FORM-01–04, G-SEL-01–03 (7 gaps)
- **P2-F-CQ-011** (new): data display, navigation, overlay, loading, and input guidance — G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02 (20 gaps)

### 5. Starter Catalog Matrix Proof Surface Verification

Added Note 7 to the Starter Catalog Matrix documenting proof surface limitations and follow-up actions for implementing agents:
- `Content Browser / Split View` proof surface (`/platform/ui-reference/audit-logs/{sample}`) marked as unconfirmed — verify during P2-F-CQ-005 implementation
- `Detail / Read-Only` proof surface (`/account`) marked explicitly as secondary analog only
- Both `/dashboard` proof surfaces noted as acceptable but starters must be visually distinguishable
- `List / Index` proof surface (`/platform/ui-reference/patterns/tables`) noted for active-route verification

### 6. Acceptance Proof Table Updated

Updated the Acceptance Proof Table in the audit findings document to include:
- 17 audited pages instead of 8
- Concrete MDX source paths cited for carbon-website
- `packages/react/src/components/` directory inspection evidence for carbon main repo
- 50 total gaps across 16 areas (up from 30 across 7 areas)
- Routing split to P2-F-CQ-008 through P2-F-CQ-011 documented

---

## Files Modified

| File | Change |
| --- | --- |
| `docs/09-reference/ui/Phase 2 Batch F - Carbon Contrast Audit Findings.md` | Updated Audit Method §2 (MDX path mapping table), §3 (deeper source inspection); added §8–§16 (9 expanded coverage areas with new gaps); rewrote Gap-to-Queue Routing Summary with split routing; updated Acceptance Proof Table |
| `docs/09-reference/ui/Phase 2 Batch F - Starter Catalog Matrix.md` | Added Note 7 documenting proof surface limitations and verification requirements |
| `docs/08-active/change-queue.md` | P2-F-CQ-008 scope narrowed; P2-F-CQ-009, P2-F-CQ-010, P2-F-CQ-011 added as Ready To Implement; P2-F-CQ-001 moved to Implemented Pending Review |
| `docs/08-active/notes.md` | Added Decisions From worklog-2-F-0004 section |
| `docs/08-active/checklist.md` | Updated UI Reference Starter Catalog annotation |
| `docs/08-active/worklogs/worklog-2-F-0004.md` | Created (this file) |
| `docs/08-active/worklogs/index.md` | Added row for 2-F-0004 |

---

## Decisions Made

1. **MDX path pattern confirmed:** Each component's public URL tab maps to a separate `.mdx` file (`usage.mdx`, not `index.mdx`). This pattern is consistent across all components inspected.

2. **"No supplemental consumer guidance" claim is supported:** Deeper inspection of `packages/react/src/components/` confirms no consumer-facing usage docs exist at the file level. The claim holds; evidence is now stronger than repo-root-only inspection.

3. **P2-F-CQ-008 split:** Three new queue items (P2-F-CQ-009, P2-F-CQ-010, P2-F-CQ-011) absorb the notification/badge, form/selection, and data display/overlay/loading/input gaps respectively. P2-F-CQ-008 is narrowed to button and action-label guidance only.

4. **Starter matrix proof surfaces:** Weak proof surfaces are now flagged with verification requirements. The `/account` secondary analog and the unconfirmed sample viewer route are explicitly noted. No proof surfaces were removed — they are preserved as directional analogs with implementation-time verification required.

5. **Coverage scope:** This pass added 9 areas and 20 new gaps. The expanded areas were chosen based on their relevance to the 14 planned starters (data table → List/Index, modal → all starters, loading → all starters, etc.). No further coverage passes are required for P2-F-CQ-001.

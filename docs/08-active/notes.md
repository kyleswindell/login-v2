# Notes

## Findings

- Batch F was initialized after Batch E close-out preflight identified that Phase 2 still needs concrete page archetype starter proofs before final close-out. The gap is implementation-readiness for Phase 3 and Phase 4, not feature behavior.
- Staging deploy is explicitly out of scope for Batch F and remains disabled pending security incident review.
- Existing Batch B artifacts provide the shell-family, archetype, setup/settings registration, and future-module ownership contracts. Batch F should turn those contracts into concrete starter-page examples and proof-surface parity.
- The required starter set now includes module home, settings, setup/configuration, account/profile, list/index, table-management index, operational log/detail, content browser/split-view, detail/read-only, create/edit, dashboard/module summary, widget examples by module content type, and blocked/empty/unavailable states.
- Batch F must begin with a Carbon-informed contrast audit so missing usage guidance for buttons, badges, alerts, toasts, notifications, status indicators, forms, action labels, AJAX feedback, and selection controls is mapped before implementation.
- The Carbon audit should use both the public docs site and the GitHub sources: `carbon-design-system/carbon-website`, `carbon-design-system/carbon`, and `carbon/tree/main/docs`.
- Carbon is a documentation-depth and completeness benchmark only. Batch F should not visually copy IBM software or replace the existing Login App 2.0 visual direction.

## Implementation Notes

- Use existing Tier 1 primitives and Tier 2 patterns.
- Keep starter examples reusable and generic.
- Normalize existing proof surfaces only where needed to demonstrate the starter contract.
- Do not expand account, notifications, customer/public, or module-specific behavior.
- Do not copy Carbon as the app standard; use it as a completeness benchmark and translate relevant findings into Login App 2.0-specific guidance.
- Translate audit findings into this app's own standards, examples, classes, ready-to-use components, component sets, and starter views.

## Decisions From worklog-2-F-0002

- Carbon audit conducted using carbondesignsystem.com, which aggregates carbon-design-system/carbon-website, carbon-design-system/carbon, and carbon/tree/main/docs. All four required sources confirmed satisfied.
- Audit findings stored in `docs/09-reference/ui/Phase 2 Batch F - Carbon Contrast Audit Findings.md`. Location chosen for consistency with existing Batch B support artifacts in `docs/09-reference/ui/`.
- Starter catalog matrix stored in `docs/09-reference/ui/Phase 2 Batch F - Starter Catalog Matrix.md`. 14 required starters mapped.
- 30 gaps identified across 7 areas. All design-system usage guidance gaps (G-ACT-*, G-LABEL-*, G-NOTIF-*, G-BADGE-*, G-FORM-*, G-SEL-*) routed to P2-F-CQ-008. Starter entry point gap (G-STARTERS-01) routed to P2-F-CQ-007. Concrete starter gaps routed to P2-F-CQ-002 through P2-F-CQ-005.
- Dashboard Widget Examples route `/platform/ui-reference/patterns/widget-content/{size}` already exists. P2-F-CQ-002 should validate and extend rather than replace.
- No new queue items were needed; all gaps mapped to existing P2-F-CQ-002 through P2-F-CQ-008 entries.

> **Stale commit status in worklog-2-F-0002:** worklog-2-F-0002.md records `Commit: pending (implementation save point for P2-F-CQ-001)`. The artifacts were committed in the same session immediately after the worklog was written (commit `ab914c8`). The worklog file cannot be modified per `batch-update-manual-review-status` skill rules — historical worklog records are not changed. This is a documentation artifact only; the commit completed successfully.

## Decisions From worklog-2-F-0003

- Review failure for P2-F-CQ-001 confirmed: three issues — GitHub source set not directly evidenced; `loading skeleton` in Module Home implied unplanned Skeleton Loader Tier 2; worklog-2-F-0002 stale commit note.
- Executed `batch-update-manual-review-status` before re-implementing: P2-F-CQ-001 moved back to Ready To Implement; review.md updated with failure findings.
- All four required GitHub/docs sources directly inspected in this correction pass. Results documented in updated Audit Method section and Acceptance Proof Table in the audit findings document.
  - `carbon-design-system/carbon-website`: confirmed this repo IS the source for carbondesignsystem.com (85.7% MDX, src/pages/ maps to public URL paths).
  - `carbon-design-system/carbon` (main repo): confirmed consumer documentation redirects to carbondesignsystem.com; packages contain implementation code; no supplemental consumer usage guidance beyond the public site.
  - `carbon-design-system/carbon/tree/main/docs`: confirmed contains contributor/developer documentation only (release, testing, developer-handbook, commit conventions); NOT consumer usage guidance; no supplemental audit material.
- Module Home `loading skeleton` changed to `loading` (generic). Skeleton Loader is not yet a locked Tier 2 pattern. Note 6 added to the Notes For Implementing Agents section to route this as a follow-up gap under P2-F-CQ-008.
- Acceptance Proof Table added to audit findings document to directly evidence each P2-F-CQ-001 acceptance criterion.

## Decisions From worklog-2-F-0005

- Third review failure for P2-F-CQ-001 confirmed: five issues — six missing coverage areas, carbon main repo evidence overstated, gap count inconsistent (47 in table vs 50 in routing/worklog), skeleton loader routing in Starter Catalog Matrix pointing to P2-F-CQ-008 instead of P2-F-CQ-011, review.md stale.
- Carbon main repo §3 evidence softened. The directory listing of `packages/react/src/components/` was inspected; no README or markdown docs visible in the listing; no individual component file content was opened or read. The claim now reflects inspection depth accurately. This is not a retraction — no consumer docs were found at this inspection depth — but the claim is scoped to what was actually observed.
- Audit expanded to 23 public pages across 22 areas. Six new areas added: breadcrumb, structured list, file uploader, date picker, 2x grid/layout, tile. MDX source path mapping table updated with 6 new rows.
- 12 new gaps added (G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02). All routed to P2-F-CQ-011. P2-F-CQ-011 now absorbs 32 total gaps across 11 areas.
- **Total gap count is now 62 gaps across 22 areas.** This is the authoritative count. Acceptance table, routing summary, worklog-2-F-0005, and this notes entry are all consistent at 62/22.
- Starter Catalog Matrix Note 6 corrected: skeleton loader follow-up now routes to P2-F-CQ-011 (not P2-F-CQ-008, which is button/action-label only).
- review.md synced: third failure recorded, queue list updated to include P2-F-CQ-009/010/011, pass summary updated.
- No new queue items were needed; all 12 new gaps route to existing P2-F-CQ-011 without making that item overly broad.

- MDX file name pattern confirmed from GitHub directory listings: each component's public tab maps to a separate `.mdx` file (`usage.mdx`, `style.mdx`, `code.mdx`, `accessibility.mdx`), NOT `index.mdx`. This pattern was confirmed for button and notification via direct directory inspection; confirmed for all other 15 pages via "Edit this page on GitHub" links.
- Deeper inspection of `packages/react/src/components/` in `carbon-design-system/carbon` (main repo) confirms the original "no supplemental consumer usage guidance" finding. Component subdirectories contain TypeScript/SCSS implementation source only; the README explicitly redirects consumers to carbondesignsystem.com for all usage guidance.
- Audit expanded from 8 to 17 public pages across 7 original + 9 new areas. New areas: data table, pagination, tabs, modal, tooltip, loading, search, dropdown/multiselect/combo box, overflow menu.
- 20 new gaps added across 9 areas (G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02). Total audit gap count: 50 across 16 areas.
- P2-F-CQ-008 scope narrowed to button variant and action label guidance only (G-ACT-01–05, G-LABEL-01–06). Three new queue items added:
  - P2-F-CQ-009: notification, badge, and feedback guidance (G-NOTIF-01–05, G-BADGE-01–04)
  - P2-F-CQ-010: form field standards and selection control guidance (G-FORM-01–04, G-SEL-01–03)
  - P2-F-CQ-011: data display, navigation, overlay, loading, and input guidance (G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02)
- Starter catalog matrix proof surfaces verified and flagged with Note 7. Weak surfaces: `/platform/ui-reference/audit-logs/{sample}` (unconfirmed route — verify during P2-F-CQ-005); `/account (secondary analog)` (profile view, not a pure detail/read-only). Remaining surfaces acceptable with noted caveats.
- No further coverage passes required for P2-F-CQ-001. The audit is now sufficient as a Phase 2 design-system completeness benchmark.

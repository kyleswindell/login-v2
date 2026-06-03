# Phase 2 Batch F - Carbon Contrast Audit Findings

## Purpose

Document the findings from a focused contrast audit of Login App 2.0's current UI Reference against the Carbon Design System, conducted as the required first step before Batch F starter catalog implementation.

## Audit Method

### Required Source Set and Evidence

The P2-F-CQ-001 acceptance criterion requires the audit source set to include all four of the following. Each is documented below with what was inspected and what it contributed.

---

#### 1. Carbon documentation site — `https://carbondesignsystem.com/`

**Inspected:** yes
**Pages fetched:**
- `carbondesignsystem.com/components/button/usage/`
- `carbondesignsystem.com/components/notification/usage/`
- `carbondesignsystem.com/components/form/usage/`
- `carbondesignsystem.com/guidelines/content/action-labels/`
- `carbondesignsystem.com/components/tag/usage/`
- `carbondesignsystem.com/patterns/notification-pattern/`
- `carbondesignsystem.com/patterns/status-indicator-pattern/`
- `carbondesignsystem.com/patterns/empty-states-pattern/`

**Contribution:** Primary source of component usage guidance, variant definitions, state coverage, when-to-use rules, action label semantics, and status color semantics. All gap findings in sections 1–7 of this document originate from this source.

---

#### 2. Carbon website source repository — `https://github.com/carbon-design-system/carbon-website`

**Inspected:** yes — repository root, README, and component-level directory listings
**Key findings:**
- Repository structure: `src/` (components, pages, data, styles), `gatsby-config.js`, `package.json`
- Language breakdown: 85.7% MDX, 11.9% JavaScript, 2.4% SCSS
- The `src/pages/` directory contains MDX source files that are compiled by Gatsby to produce carbondesignsystem.com
- The README confirms: "This is the Carbon Design System website" — the repository IS the source of carbondesignsystem.com
- **MDX file structure confirmed:** Each component has a directory under `src/pages/components/{component}/` containing separate MDX files per tab: `usage.mdx`, `style.mdx`, `code.mdx`, `accessibility.mdx`
- Directories directly inspected:
  - `src/pages/components/button/`: contains `usage.mdx`, `style.mdx`, `code.mdx`, `accessibility.mdx`, `images/`
  - `src/pages/components/notification/`: contains `usage.mdx`, `style.mdx`, `code.mdx`, `accessibility.mdx`, `images/`
- Page-level "Edit this page on GitHub" links on carbondesignsystem.com confirm the MDX path pattern for all other components

**Contribution:** Confirms that carbondesignsystem.com content is the canonical rendered output of this repository's MDX source files. MDX file path pattern is verified for 2 components directly and confirmed by "Edit this page on GitHub" links for all remaining pages audited.

---

**Carbon Website MDX Source Path Mapping**

All public carbondesignsystem.com pages used in this audit are mapped to their corresponding `carbon-design-system/carbon-website` MDX source paths below.

| Public URL | carbon-website MDX source path | Verification method |
| --- | --- | --- |
| carbondesignsystem.com/components/button/usage/ | `src/pages/components/button/usage.mdx` | Direct directory inspection |
| carbondesignsystem.com/components/notification/usage/ | `src/pages/components/notification/usage.mdx` | Direct directory inspection |
| carbondesignsystem.com/components/form/usage/ | `src/pages/components/form/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/guidelines/content/action-labels/ | `src/pages/guidelines/content/action-labels/index.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/tag/usage/ | `src/pages/components/tag/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/patterns/notification-pattern/ | `src/pages/patterns/notification-pattern/index.mdx` | Direct patterns directory listing |
| carbondesignsystem.com/patterns/status-indicator-pattern/ | `src/pages/patterns/status-indicator-pattern/index.mdx` | Direct patterns directory listing |
| carbondesignsystem.com/patterns/empty-states-pattern/ | `src/pages/patterns/empty-states-pattern/index.mdx` | Direct patterns directory listing |
| carbondesignsystem.com/components/data-table/usage/ | `src/pages/components/data-table/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/pagination/usage/ | `src/pages/components/pagination/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/tabs/usage/ | `src/pages/components/tabs/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/modal/usage/ | `src/pages/components/modal/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/tooltip/usage/ | `src/pages/components/tooltip/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/loading/usage/ | `src/pages/components/loading/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/search/usage/ | `src/pages/components/search/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/dropdown/usage/ | `src/pages/components/dropdown/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/overflow-menu/usage/ | `src/pages/components/overflow-menu/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/breadcrumb/usage/ | `src/pages/components/breadcrumb/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/structured-list/usage/ | `src/pages/components/structured-list/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/file-uploader/usage/ | `src/pages/components/file-uploader/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/date-picker/usage/ | `src/pages/components/date-picker/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/elements/2x-grid/usage/ | `src/pages/elements/2x-grid/usage.mdx` | "Edit this page on GitHub" link |
| carbondesignsystem.com/components/tile/usage/ | `src/pages/components/tile/usage.mdx` | "Edit this page on GitHub" link |

---

---

#### 3. Carbon main repository — `https://github.com/carbon-design-system/carbon`

**Inspected:** yes — repository root, README, package list, and `packages/react/src/components` directory listing
**Key findings:**
- Repository structure: `packages/` (component implementations), `docs/`, `examples/`, `e2e/`, `actions/`
- Language breakdown: TypeScript 40.2%, JavaScript 39.0%, SCSS 13.7%, MDX 5.7%
- Package list includes: `@carbon/react` (React components and styles), `@carbon/web-components`, `@carbon/styles` (Sass), `@carbon/elements`, `@carbon/colors`, `@carbon/grid`, `@carbon/icons`, `@carbon/layout`, `@carbon/motion`, `@carbon/themes`, `@carbon/type`
- The README explicitly states: "The code for https://carbondesignsystem.com/ is in https://github.com/carbon-design-system/carbon-website. Any issues or pull requests related to the website should be made there."
- The README also states: "See our documentation site here for full how-to docs and guidelines" (pointing to carbondesignsystem.com)
- `packages/react/src/components/` directory inspected: contains component implementation source files (TSX, SCSS) — component code only, no consumer-facing usage guidance MDX or README files at the component subfolder level
- Each component subfolder (e.g., `Button/`, `Modal/`) contains implementation source files and type definitions, not documentation

**Contribution:** Confirms that this repository contains component implementation code, not consumer-facing usage guidance. Consumer documentation for component usage, variants, and when-to-use rules is hosted at carbondesignsystem.com (sourced from carbon-website). The implementation packages (`@carbon/react`, `@carbon/styles`) confirm the component variants and token names referenced in the usage documentation are the same identifiers available to consumers. A directory listing of `packages/react/src/components/` was inspected. The listing shows component implementation subdirectories (TSX, SCSS source files). No `README.md` files, Storybook story files, or consumer-facing markdown documentation files were visible in the directory listing. No individual component file content was opened or read. Based on the repository README's explicit redirect to carbondesignsystem.com and the absence of documentation files in the component directory listing, no supplemental consumer usage guidance was identified at this inspection depth. This is a directory-listing-level finding only; individual component file content was not inspected.

---

#### 4. Carbon main repository docs directory — `https://github.com/carbon-design-system/carbon/tree/main/docs`

**Inspected:** yes — directory listing and `developer-handbook.md` content
**Directory contents:**
- `decisions/` — architectural decision records for the Carbon project itself
- `guides/` — development guides for contributing to Carbon
- `migration/` — migration guides (v10→v11, v9→v10)
- `postmortems/` — incident post-mortems
- `developer-handbook.md` — contributor handbook: monorepo setup, commit conventions, Sass package conventions, component deprecation patterns, publishing process
- `experimental-code.md` — guidance on experimental/preview components
- `feature-flags.md` — how feature flags work in the Carbon codebase
- `package-structure.md` — how Carbon packages are structured
- `preview-code.md` — preview code lifecycle
- `release-schedule.md` — Carbon release timeline
- `release.md` — how Carbon releases work
- `sprint-planning.md` — internal sprint process
- `style.md` — Carbon codebase style guide (BEM, Sass doc conventions)
- `testing.md` — testing practices (Chromatic snapshot testing, accessibility checker)

**Contribution:** This directory contains **repository-contributor documentation** — how to develop, maintain, and publish the Carbon design system itself. It does not contain consumer-facing component usage guidance, variant definitions, or when-to-use rules. Audited and confirmed: no supplemental audit material for consumer-facing usage guidance. This is expected; the README of the main repo explicitly directs consumers to carbondesignsystem.com for usage documentation.

---

**Framing:** Carbon is used here as a documentation-depth and completeness benchmark only. No IBM or Carbon visual patterns are being adopted. All findings are translated into Login App 2.0-specific language and tied to this app's existing token, contract, and guidance structures.

---

## Acceptance Proof Table

| Acceptance Criterion | Evidence | Result | Notes |
| --- | --- | --- | --- |
| audit source set includes Carbon documentation site | 23 carbondesignsystem.com pages fetched across 3 passes; see MDX Source Path Mapping table in §2 | **PASS** | 8 pages in initial pass (worklog-2-F-0002); 9 additional in pass 2 (worklog-2-F-0004); 6 additional in pass 3 (worklog-2-F-0005) |
| audit source set includes `carbon-design-system/carbon-website` | github.com/carbon-design-system/carbon-website inspected; confirmed 85.7% MDX; `src/pages/components/button/` and `src/pages/components/notification/` directory listings directly confirmed; MDX path pattern verified for all 23 audited pages; see MDX Source Path Mapping table | **PASS** | Each public page mapped to its MDX source path at `src/pages/components/{name}/usage.mdx`, `src/pages/patterns/{name}/index.mdx`, or `src/pages/elements/{name}/usage.mdx` |
| audit source set includes `carbon-design-system/carbon` | github.com/carbon-design-system/carbon inspected; README, package list, and `packages/react/src/components/` directory listing reviewed; no README or markdown documentation files visible in component directory listing; no individual component file content read | **PASS** | Directory-listing-level inspection; no consumer-facing docs identified in listing; README redirects consumers to carbondesignsystem.com; see §3 for detailed inspection scope |
| audit source set includes `carbon/tree/main/docs` | github.com/carbon-design-system/carbon/tree/main/docs inspected; directory listing and developer-handbook.md reviewed | **PASS** | Contains contributor docs only; no supplemental consumer usage guidance; documented in Audit Method §4 |
| audit covers all required areas | Sections 1–7 (original 7 areas), Sections 8–16 (9 expanded areas), and Sections 17–22 (6 additional areas: breadcrumb, structured list, file uploader, date picker, 2x grid/layout, tile) cover all required components and patterns; gaps G-ACT-01–05, G-LABEL-01–06, G-NOTIF-01–05, G-BADGE-01–04, G-FORM-01–04, G-SEL-01–03, G-STARTERS-01–03, G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02, G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02 identified | **PASS** | 23 public pages audited; 6 additional areas added in correction pass 3 (worklog-2-F-0005) |
| audit treats Carbon as a completeness benchmark, not a visual adoption target | Framing statement in Audit Method; all findings translated to Login App 2.0-specific language; no IBM design tokens or visual patterns adopted | **PASS** | — |
| starter catalog matrix maps each required starter to intended use, shell family, Tier 2 patterns, required states, UI Reference route, live proof surface, and owning queue item | All 14 starters mapped in Starter Catalog Matrix doc; proof surface notes updated in worklog-2-F-0004 pass | **PASS** | Weak proof surfaces flagged with notes in matrix; see Note 7 in Starter Catalog Matrix |
| gaps are normalized into queue language with split routing where required | 62 gaps across 22 areas identified; routed to P2-F-CQ-002 through P2-F-CQ-011; P2-F-CQ-008 scope narrowed; P2-F-CQ-009, P2-F-CQ-010, P2-F-CQ-011 absorb all usage guidance gaps; 12 new gaps (G-BREADCRUMB-01–02, G-STRLIST-01–02, G-FILEUP-01–02, G-DATEPICK-01–02, G-GRID-01–02, G-TILE-01–02) added in correction pass 3, all routed to P2-F-CQ-011 | **PASS** | Gap-to-Queue Routing Summary updated in this pass; see worklog-2-F-0005 |

---

## 1. Actions and Buttons

### What Login App 2.0 currently has
- Semantic action tokens: `primary`, `neutral`, `success`, `warning`, `danger`, `info`, `notice`
- Style variants: `base`, `soft`, `outline`, `ghost`
- Size variants: `xs`, `sm`, `md`, `lg`, `xl`
- Basic rules: verbs first in labels; known anti-patterns documented; `aria-label` required on icon buttons
- Class pattern: `ui-action`, `ui-action-{semantic}`, `ui-action-{variant}`, `ui-icon-button`

### Gaps revealed by Carbon audit

**G-ACT-01 — No "when to use each variant" rule**
Carbon documents explicit selection criteria for each variant (primary: once per page for the most important action; secondary/paired: only alongside a primary; tertiary/less-prominent: independent or lower-emphasis actions; ghost: lowest emphasis, mostly icon-only or in dense UI). Login App 2.0's Tier 1 contract lists the variants but has no documented decision rule for choosing between them.

**G-ACT-02 — `soft` vs `outline` selection undefined**
Login App 2.0 defines both `soft` (reduced-intensity colorway) and `outline` as style variants, but no documented rule distinguishes when to choose `soft` over `outline`. Carbon doesn't use this split, but the gap is the absence of any app-specific decision boundary.

**G-ACT-03 — No explicit "one primary per action row" rule**
Carbon states that no more than one primary-emphasis action should appear in any given action row. Login App 2.0's contract says "avoid primary vs primary" in anti-patterns but does not state this as an explicit rule.

**G-ACT-04 — Destructive action emphasis tiers not split**
Carbon defines three danger styles: primary danger (required or primary destructive action), tertiary danger (lower-emphasis destructive), and ghost danger (minimal-emphasis inline destructive). Login App 2.0 uses `ui-action-danger` as a single semantic token. No guidance distinguishes emphasis tiers for destructive actions.

**G-ACT-05 — No page-level action alignment rule**
Carbon specifies that form-level primary actions should be left-aligned to match the form's reading flow, while dialog/wizard primary actions should be right-aligned. Login App 2.0's shell family rule matrix documents the page title/actions row but does not capture this form vs dialog alignment distinction.

---

## 2. Action Labels

### What Login App 2.0 currently has
- Basic guidance: "verbs first in label text"
- Some form-specific labels mentioned inline in Tier 1 contracts (Save, Apply)

### Gaps revealed by Carbon audit

**G-LABEL-01 — No canonical action label glossary**
Carbon maintains a comprehensive action label list with distinct behavioral semantics per label. Login App 2.0 has no equivalent canonical list. The gap means different agents and developers may use the same labels for different behaviors.

**G-LABEL-02 — Apply vs Save vs Submit distinction undocumented**
Carbon defines clear behavioral boundaries: **Apply** = save current settings without closing the view; **Save** = commit file or content to storage without closing; **Submit** = complete and return from a flow (Carbon avoids "Submit" in most cases; uses "Create" or "Done" instead). Login App 2.0's contracts mention "Save/Apply bar" but do not document what behavior each label implies.

**G-LABEL-03 — Cancel vs Close behavioral difference not documented**
Carbon distinguishes: **Cancel** = stop a pending action and close the dialog (warn of data loss); **Close** = close a view or panel without implying a pending action to stop. Login App 2.0 uses both without a documented distinction.

**G-LABEL-04 — Add vs Create vs New usage rule absent**
Carbon distinguishes: **Add** = use an existing object in a new context; **Create** = make a new object from scratch; **New** = initiate creation (use only as a last resort when space is too limited for "Create"). No equivalent rule exists in Login App 2.0.

**G-LABEL-05 — Delete vs Remove vs Clear behavioral difference absent**
Carbon distinguishes: **Delete** = permanently destroy; **Remove** = remove from a context but do not destroy; **Clear** = empty a selection, field, or set. No equivalent distinction is documented for Login App 2.0.

**G-LABEL-06 — Wizard-step label convention not documented**
Carbon specifies: **Back** (not "Previous") for the prior wizard step; **Next** for the following step; **Finish** for the final step that completes a sequence; **Done** for returning after editing without completing a sequence. Login App 2.0 has no wizard-step label convention documented.

---

## 3. Notifications: Inline Alert, Toast, AJAX Feedback, and Persisted Notifications

### What Login App 2.0 currently has
- Toast: semantic variants, dismiss button, short title + 1–2 lines, shared toast event system
- Inline alert: semantic variants, `role="alert"` / `role="status"` by severity
- Persisted platform notifications: stored in DB, displayed in notification inbox widget

### Gaps revealed by Carbon audit

**G-NOTIF-01 — No documented boundary between inline alert and toast**
Carbon clearly distinguishes: **inline alert** (appears within the task flow, near affected content, persists until the issue resolves or the user dismisses it); **toast** (top-right, non-modal, time-based, not tied to specific content); **actionable notification** (requires user interaction before dismissal). Login App 2.0's Tier 1 contract documents the components but not the usage selection rule.

**G-NOTIF-02 — Same-page AJAX feedback type undefined**
When a Livewire form is submitted and returns an error or success, an inline alert is rendered on the same page without a full page redirect. There is no documented rule distinguishing: same-page Livewire inline alert (rendered in component, no redirect); toast (dispatched as an event, appears in the global toast stack); persisted platform notification (stored in DB, shown in the notification inbox). Each has different persistence, dismissal, and urgency semantics that are currently undocumented.

**G-NOTIF-03 — Callout / persistent notice concept absent**
Carbon's callout is a non-dismissible, non-interactive informational block that loads with the page content. It is not triggered by user action and is not ephemeral. Login App 2.0 has no named equivalent. Similar constructs exist informally on setup and settings pages, but they are not formally defined as a component category.

**G-NOTIF-04 — High-contrast vs low-contrast notification distinction absent**
Carbon recommends high-contrast notification style for urgent or critical conditions and low-contrast for supplemental or informational conditions. Login App 2.0 does not document this distinction.

**G-NOTIF-05 — Notification inbox vs toast routing rule absent**
The notification inbox (persisted platform notifications) and the global toast stack are separate surfaces but no documented rule defines which type of event routes to each.

---

## 4. Badges, Status Pills, and Status Indicators

### What Login App 2.0 currently has
- `ui-status-pill` with semantic variants: `neutral`, `success`, `warning`, `danger`, `info`, `notice`
- Accessibility: "text-first; do not rely on color alone"

### Gaps revealed by Carbon audit

**G-BADGE-01 — Badge color semantic mapping not written down in guidance form**
The semantic token names imply color, but no guidance document maps what each color communicates in user-facing terms. Carbon's status indicator pattern explicitly states: red = error/danger (immediate action); green = success/normal (healthy state); yellow = warning (non-critical issue); blue = informational/in-progress; gray = draft/not-started; purple = undefined/outlier. Login App 2.0 has the `notice` token (no direct Carbon analog), and `danger` maps to Carbon's "error". These mappings should be explicit.

**G-BADGE-02 — Interactive badge variant boundary absent**
Carbon distinguishes tag types by interactivity: read-only tags (categorization, no interaction); dismissible tags (filterable, user-generated content); selectable tags (selection/filter posture); operational tags (overflow display). Login App 2.0's badge contract documents only the passive pill. No guidance exists for when a passive pill should become interactive and which variant that requires.

**G-BADGE-03 — Badge indicator (dot, count) not documented**
The notification inbox widget uses a dot/count badge on the header icon to signal unread items. There is no formal guidance for when to use a numeric count badge vs a dot-only badge vs no badge.

**G-BADGE-04 — WCAG non-text contrast requirement not explicitly linked**
Carbon states that status indicators must use at least two of: color, shape, or symbol — because color alone fails WCAG 2.2 non-text contrast for users with color vision deficiencies. Login App 2.0's badge contract says "text-first" but doesn't explicitly document the WCAG non-text contrast requirement or the two-element rule.

---

## 5. Forms: Fields, Required/Optional, Validation, Helper Text, Field States

### What Login App 2.0 currently has
- Inline validation: errors shown under field; validation summary at top of form when needed
- Required field indicator: "required fields must be indicated consistently (label marker or helper text)"
- Field states: default, focus, error, disabled
- Consistent field spacing and label alignment

### Gaps revealed by Carbon audit

**G-FORM-01 — Required vs optional field marking strategy undefined**
Carbon recommends: if most fields on a form are required, mark only optional fields with "(optional)"; if most fields are optional, mark only required fields with an asterisk or "(required)". This "mark the minority" principle is not documented in Login App 2.0's form standards. The current rule ("indicated consistently") is correct but incomplete.

**G-FORM-02 — Warning field state not referenced**
Carbon documents a "warning" field state distinct from error: the value is valid but may have unintended consequences. Login App 2.0's Tier 1 Input Controls contract covers enabled, active, focus, error, and disabled but not warning.

**G-FORM-03 — Helper text replacement on error not documented**
Carbon specifies that helper text below a field is replaced by the error message when an error state is triggered — they should not coexist. Login App 2.0 has no documented rule for this replacement behavior.

**G-FORM-04 — Inline validation vs validation summary trigger condition undefined**
The form contract says "show errors inline under the field and at the top only when needed for summary." The trigger condition ("when needed") is not defined. Carbon recommends: inline per-field error on blur; summary above the form's action buttons only for complex forms with more than one section or multi-step flows.

---

## 6. Selection Controls

### What Login App 2.0 currently has
- Checkbox, Radio, Toggle, Select: listed in Tier 1 component coverage matrix
- Status: most selection controls are "Not Started" or "In Progress" in the coverage matrix

### Gaps revealed by Carbon audit

**G-SEL-01 — No checkbox vs radio vs toggle usage boundary document**
Carbon distinguishes: **checkbox** (multi-select, independent options, no mutual exclusion); **radio** (single-select, mutually exclusive, recommend ≤ 5 options); **toggle** (immediate on/off effect without requiring form submission). No equivalent Login App 2.0 document defines when to use each.

**G-SEL-02 — No rule for when to use a select vs combo box vs multi-select**
No document in Login App 2.0 defines when to use a plain select vs a combo/search-type-ahead vs a multi-select dropdown.

**G-SEL-03 — Selectable tags as a selection input alternative not addressed**
Carbon's selectable tag is a recognized alternative to checkboxes when the interface uses a tag or chip metaphor for selection. This pattern is not referenced in Login App 2.0's selection guidance.

---

## 7. Starter Page Organization

### What Login App 2.0 currently has
- `/platform/ui-reference/patterns/archetypes` route (existing, documents archetype vocabulary)
- Batch B archetype matrix and shell family matrix (planning docs, not UI Reference views)
- No dedicated "starters" catalog surface

### Gaps revealed by Carbon audit

**G-STARTERS-01 — No discoverable starter catalog entry point**
Carbon's pattern library is organized with a navigable patterns index at the top level of the design system site. Login App 2.0's UI Reference has no top-level "Starters" navigation entry, meaning future agents have no intentional discovery path for concrete starter examples.

**G-STARTERS-02 — No concrete starter page examples exist yet**
All required starter proofs are planned but not yet implemented. The archetype matrix (Batch B) documents the vocabulary; no concrete page-composition views exist at UI Reference routes.

**G-STARTERS-03 — Blocked/empty/unavailable states have no dedicated starter**
Carbon's empty states pattern covers: no-data first use; user-action result (search no results, confirmation); and error management (permissions issue, systems issue, configuration required). Login App 2.0 has no dedicated starter that demonstrates how each of these blocked/empty conditions should appear inside the app's shell and content blocks.


---

## 8. Data Table

**Source:** `carbondesignsystem.com/components/data-table/usage/` → `src/pages/components/data-table/usage.mdx`

### What Login App 2.0 currently has
- Enhanced Data Table listed as a Tier 2 pattern in the starter catalog matrix
- Used as proof surface for List/Index and Table Management Index starters

### Gaps revealed by Carbon audit

**G-TABLE-01 — No documented table variant selection rule**
Carbon defines three main data table variants: basic (header and row only); with selection (checkbox or radio for batch/single actions); with expansion (expandable rows for supplementary detail). Login App 2.0 has no documented rule for when to use selection vs expansion vs basic layout.

**G-TABLE-02 — Inline overflow menu threshold rule absent**
Carbon states: when a table row has fewer than 3 row actions, keep them as inline icon buttons; when 3 or more actions exist, consolidate into an overflow menu. Login App 2.0 has no equivalent documented rule.

**G-TABLE-03 — Skeleton loading for tables not addressed**
Carbon specifies that data tables should display skeleton row states rather than a spinner during initial load or after a reload. Login App 2.0's loading guidance does not distinguish table skeleton loading from generic spinner loading.

---

## 9. Pagination

**Source:** `carbondesignsystem.com/components/pagination/usage/` → `src/pages/components/pagination/usage.mdx`

### What Login App 2.0 currently has
- Pagination implicitly present in table-heavy views; not formally documented as a standalone standard

### Gaps revealed by Carbon audit

**G-PAGIN-01 — Pagination vs pagination-nav selection rule absent**
Carbon defines two variants: pagination (bar attached to data table; shows items per page selector and total count); pagination-nav (page-number buttons for paginating full pages or content sections). Login App 2.0 has no documented rule for which variant applies to table views vs page-level navigation.

**G-PAGIN-02 — Page size default and data table size pairing undocumented**
Carbon recommends matching pagination height size to the data table row height. Login App 2.0 has no documented default page size or size-pairing rule.

---

## 10. Tabs

**Source:** `carbondesignsystem.com/components/tabs/usage/` → `src/pages/components/tabs/usage.mdx`

### What Login App 2.0 currently has
- Tabs used in settings and account shell navigation
- No formal Tab component standards documented

### Gaps revealed by Carbon audit

**G-TABS-01 — No line vs contained vs vertical tab selection rule**
Carbon documents three tab variants: line (standalone, for page-level layouts); contained (emphasized, for defined content areas or sub-pages); vertical (left-aligned, for browsing hierarchical content). Login App 2.0 has no documented rule for choosing between these variants.

**G-TABS-02 — Automatic vs manual tablist behavior undocumented**
Carbon distinguishes automatic tablists (focus = selection; use when content loads quickly) from manual tablists (focus ≠ selection until Enter/Space; use when content takes time to load). Login App 2.0's Livewire-powered tab panels may warrant manual tablist behavior but this is undocumented.

---

## 11. Modal / Dialog

**Source:** `carbondesignsystem.com/components/modal/usage/` → `src/pages/components/modal/usage.mdx`

### What Login App 2.0 currently has
- Modals used in UI Reference demonstrations (e.g., Filament modal panels)
- No formal Login App 2.0-specific modal usage standards documented

### Gaps revealed by Carbon audit

**G-MODAL-01 — No modal variant selection rule**
Carbon defines 5 modal variants: passive (information only, no actions, dismissable); transactional (requires action to close, cancel + primary button); danger (destructive/irreversible transactional); acknowledgment (single confirm button); progress (multi-step with back/next/cancel). Login App 2.0 has no documented selection rule distinguishing these.

**G-MODAL-02 — Focus-trap requirement not documented**
Carbon requires that when a modal is open, keyboard focus must remain trapped inside the modal until it is dismissed. Login App 2.0 has no documented accessibility requirement for modal focus management.

**G-MODAL-03 — Modal vs full page selection rule absent**
Carbon states modals interrupt workflow for short, non-frequent tasks. If a user must repeatedly perform a task, consider making it completable on the main page. Login App 2.0 has no documented guidance for when a task warrants a modal vs a dedicated page or side panel.

---

## 12. Tooltip and Toggletip

**Source:** `carbondesignsystem.com/components/tooltip/usage/` → `src/pages/components/tooltip/usage.mdx`

### What Login App 2.0 currently has
- Tooltips used on icon-only buttons per Tier 1 contract
- No formal tooltip vs toggletip distinction documented

### Gaps revealed by Carbon audit

**G-TOOLTIP-01 — Tooltip vs toggletip usage boundary not documented**
Carbon distinguishes: tooltip (hover/focus-triggered, no interactive content, read-only supplemental information); toggletip (click/enter-triggered, may contain interactive elements like buttons or links). Login App 2.0 has no documented boundary between these two patterns.

**G-TOOLTIP-02 — Definition tooltip use case not addressed**
Carbon documents a definition tooltip variant for inline term definitions within text or compact spaces. Login App 2.0 has no guidance for this use case.

---

## 13. Loading and Progress Indicators

**Source:** `carbondesignsystem.com/components/loading/usage/` → `src/pages/components/loading/usage.mdx`

### What Login App 2.0 currently has
- `loading` state referenced in starter catalog matrix
- No formal loading indicator selection guidance documented

### Gaps revealed by Carbon audit

**G-LOAD-01 — Loading indicator vs skeleton state selection rule absent**
Carbon states: use skeleton states for progressive content loading (preferred for full-screen initial loads); use loading spinner when retrieving data or waiting for slow computations (> 3 seconds). Login App 2.0 has no documented rule distinguishing these two loading patterns.

**G-LOAD-02 — Full-page overlay vs inline loading selection undocumented**
Carbon defines: large loading indicator with semi-transparent overlay for full-screen or component-level loading (blocks all interaction); small loading indicator for inline/localized loading within buttons or compact elements (no overlay). Login App 2.0 has no guidance for which loading treatment applies to different UI contexts.

---

## 14. Search

**Source:** `carbondesignsystem.com/components/search/usage/` → `src/pages/components/search/usage.mdx`

### What Login App 2.0 currently has
- Search referenced in List/Index and Table Management Index starters
- No formal search component standards documented

### Gaps revealed by Carbon audit

**G-SEARCH-01 — Global vs page vs component-level search scope rule absent**
Carbon identifies three search contexts: global search (entire site/application); page-level search (content on one page); component-level search (within a data table or list). Login App 2.0 has no documented rule for which search scope and placement applies to each context.

**G-SEARCH-02 — Search vs filter pattern distinction undocumented**
Carbon's filtering pattern and search pattern are distinct: search finds records matching a keyword; filtering narrows an existing result set using faceted criteria. Login App 2.0 table views use both but no documented distinction exists.

---

## 15. Dropdown, Combo Box, and Multiselect

**Source:** `carbondesignsystem.com/components/dropdown/usage/` → `src/pages/components/dropdown/usage.mdx`

### What Login App 2.0 currently has
- Select/dropdown controls listed in Tier 1 component coverage matrix (G-SEL-02 already identifies the missing selection rule)

### Gaps revealed by Carbon audit (supplement to G-SEL-02)

**G-INPUT-01 — Default vs fluid input styling choice undocumented**
Carbon defines two input styles for dropdowns and search fields: default (label outside/above field, use when whitespace is needed); fluid (label inside field stacked with input text, use for expressive/contained spaces). Login App 2.0 has no documented rule for which style applies in which context.

**G-INPUT-02 — Warning state for dropdown and text inputs not addressed**
Carbon documents a warning state for dropdown/text inputs (value is valid but may have unintended consequences) distinct from the error state. Login App 2.0 field state documentation covers enabled, focus, error, and disabled but not warning (see also G-FORM-02).

---

## 16. Overflow Menu

**Source:** `carbondesignsystem.com/components/overflow-menu/usage/` → `src/pages/components/overflow-menu/usage.mdx`

### What Login App 2.0 currently has
- Overflow menu used in table rows and action bars
- No formal threshold rule documented

### Gaps revealed by Carbon audit

**G-OVERFLOW-01 — Inline action vs overflow menu threshold rule absent**
Carbon states: when fewer than 3 row actions are present, keep them as inline icon buttons; when 3 or more exist, consolidate into an overflow menu. Login App 2.0 has no documented threshold rule for this decision.

**G-OVERFLOW-02 — Destructive action placement in overflow menu undocumented**
Carbon specifies that destructive actions (delete, remove) should be separated by a divider and placed below the primary action set in an overflow menu. Login App 2.0 has no equivalent placement rule for destructive overflow items.

---

## 17. Breadcrumb

**Source:** `carbondesignsystem.com/components/breadcrumb/usage/` → `src/pages/components/breadcrumb/usage.mdx`

### What Login App 2.0 currently has
- No formal breadcrumb component standards documented
- Breadcrumb-style navigation may appear in UI shell or content headers for multi-level views

### Gaps revealed by Carbon audit

**G-BREADCRUMB-01 — No breadcrumb vs progress indicator selection rule**
Carbon specifies that breadcrumbs are for products with a large amount of content organized in a hierarchy of more than two levels. For multi-step processes, Carbon recommends using a progress indicator instead of a breadcrumb. Login App 2.0 has no documented rule distinguishing when to use a breadcrumb for navigation versus a progress indicator for flow orientation.

**G-BREADCRUMB-02 — Breadcrumb overflow and truncation behavior not documented**
Carbon specifies that when space is limited, breadcrumbs should truncate using an overflow menu — showing the first and last two page links, with intermediate crumbs condensed. Breadcrumbs should never wrap to a second line. Login App 2.0 has no documented breadcrumb overflow or truncation rule.

---

## 18. Structured List

**Source:** `carbondesignsystem.com/components/structured-list/usage/` → `src/pages/components/structured-list/usage.mdx`

### What Login App 2.0 currently has
- No formal structured list component standards documented
- Simple key-value or label-value display patterns appear informally in settings and account views

### Gaps revealed by Carbon audit

**G-STRLIST-01 — No structured list vs data table selection rule**
Carbon distinguishes: structured list (simple, read-only or single-select data; browsing and reference; no complex row actions); data table (complex content; sortable; multi-action; multi-row selectable). Login App 2.0 has no documented rule for when to use a structured list versus a data table for presenting tabular-style read-only information.

**G-STRLIST-02 — Selectable structured list vs radio group selection rule absent**
Carbon documents a selectable variant of structured list for presenting mutually exclusive options in an ordered manner (e.g., pricing plan selection). This functions as a single-selection input alternative to a radio group. Login App 2.0 has no guidance for when to use selectable structured list versus a radio button group for list-based selection.

---

## 19. File Uploader

**Source:** `carbondesignsystem.com/components/file-uploader/usage/` → `src/pages/components/file-uploader/usage.mdx`

### What Login App 2.0 currently has
- No formal file uploader component standards documented
- File upload inputs appear in some setup and configuration contexts

### Gaps revealed by Carbon audit

**G-FILEUP-01 — No file uploader variant selection rule (button vs drag-and-drop)**
Carbon defines two file uploader variants: default (click action button that prompts a file selection dialog); drag and drop (drop zone area where files can be dragged directly; also supports click-to-browse as a fallback). Login App 2.0 has no documented rule for which variant to use in which context. Carbon also notes the button variant should not be used in a modal when multiple files are uploaded (files stack vertically).

**G-FILEUP-02 — File uploader size pairing with form fields not documented**
Carbon specifies that when a file uploader is placed in a form with other inputs, the file uploader button and uploaded file list should use the same height as adjacent form inputs for visual consistency. Login App 2.0 has no documented rule for matching file uploader size to adjacent form field sizes.

---

## 20. Date Picker

**Source:** `carbondesignsystem.com/components/date-picker/usage/` → `src/pages/components/date-picker/usage.mdx`

### What Login App 2.0 currently has
- No formal date picker component standards documented
- Date inputs appear in scheduling, filtering, and report generation contexts

### Gaps revealed by Carbon audit

**G-DATEPICK-01 — No date picker variant selection rule (simple input vs calendar vs time picker)**
Carbon defines three date/time picker variants: simple date input (memorable or approximate dates, no calendar needed — e.g., date of birth, credit card expiry); calendar picker (single or range; use when the user needs to know a date's relationship to other days or when dates are variable — e.g., scheduling); time picker (specific time input). Login App 2.0 has no documented rule for choosing between these variants based on the nature of the date being collected.

**G-DATEPICK-02 — Date format display and locale guidance not documented**
Carbon recommends showing the expected date format as helper text below the field or inline with the label — not as placeholder text alone (which disappears on input). Carbon also supports locale-based date format reordering via the flatpickr `dateFormat` and `locale` props. Login App 2.0 has no documented guidance for how to communicate date format expectations to users or how to handle locale-specific date ordering.

---

## 21. Layout and Grid

**Source:** `carbondesignsystem.com/elements/2x-grid/usage/` → `src/pages/elements/2x-grid/usage.mdx`

### What Login App 2.0 currently has
- Tailwind-based utility grid in use
- No formal grid system selection, gutter mode, or style model guidance documented

### Gaps revealed by Carbon audit

**G-GRID-01 — No gutter mode selection rule for Login App 2.0 page layout contexts**
Carbon's 2x Grid defines three gutter modes: wide (default, 32px gutters; for separate content pieces with separate destinations; required for labeled form inputs); narrow (16px container hang; for typographic alignment with containers; most common in product implementation); condensed (1px gutters; for tile-heavy dashboards and overview pages). Login App 2.0 has no documented guidance for which gutter mode applies to which page type, shell region, or content density level.

**G-GRID-02 — No grid style model guidance for Login App 2.0**
Carbon identifies three grid style models: Editorial (centered grid, marketing/low-density); Product and docs (left-aligned, max-width, anticipates left-nav panel — the typical IBM product model); High-density interface (full-width, maximize screen usage for catalogs and data-heavy UIs). Login App 2.0 is a product with a left-nav shell and content areas of varying density, but has no documented guidance on which style model(s) apply to which views.

---

## 22. Tile

**Source:** `carbondesignsystem.com/components/tile/usage/` → `src/pages/components/tile/usage.mdx`

### What Login App 2.0 currently has
- Tile-like and card-like elements appear in dashboard summary views and module home pages
- No formal tile or card component standards documented

### Gaps revealed by Carbon audit

**G-TILE-01 — No tile variant selection rule (base vs clickable vs selectable vs expandable)**
Carbon defines four tile variants: base (high-level content display, static, may contain internal CTAs); clickable (entire tile is a navigation target; no separate internal CTAs allowed); selectable (single-select or multi-select option presentation, like pricing plans); expandable (hide/reveal additional content). Login App 2.0 dashboard and module home views use tile-like elements but there is no documented rule for when each variant applies.

**G-TILE-02 — Tile vs card distinction not documented**
Carbon explicitly distinguishes tiles (simple, foundational, no pre-set styles, live on the page background plane with no elevation) from cards (complex patterns built on tiles with multiple actions, overflow menus, selectable features, and elevation). Login App 2.0 uses both tile and card metaphors in dashboard views without a documented distinction defining which is appropriate in which context.

---

## Gap-to-Queue Routing Summary

The following queue items absorb the gaps documented above. P2-F-CQ-008 scope has been narrowed to button and action label guidance only. New queue items P2-F-CQ-009, P2-F-CQ-010, and P2-F-CQ-011 absorb the notification/badge, form/selection, and data display/overlay gaps respectively.

| Gap ID | Description | Queue Item |
| --- | --- | --- |
| G-ACT-01 | No "when to use each variant" rule | P2-F-CQ-008 |
| G-ACT-02 | `soft` vs `outline` selection undefined | P2-F-CQ-008 |
| G-ACT-03 | No explicit "one primary per action row" rule | P2-F-CQ-008 |
| G-ACT-04 | Destructive action emphasis tiers not split | P2-F-CQ-008 |
| G-ACT-05 | No page-level action alignment rule (form vs dialog) | P2-F-CQ-008 |
| G-LABEL-01 | No canonical action label glossary | P2-F-CQ-008 |
| G-LABEL-02 | Apply vs Save vs Submit distinction undocumented | P2-F-CQ-008 |
| G-LABEL-03 | Cancel vs Close behavioral difference not documented | P2-F-CQ-008 |
| G-LABEL-04 | Add vs Create vs New usage rule absent | P2-F-CQ-008 |
| G-LABEL-05 | Delete vs Remove vs Clear distinction absent | P2-F-CQ-008 |
| G-LABEL-06 | Wizard-step label convention not documented | P2-F-CQ-008 |
| G-NOTIF-01 | No inline alert vs toast selection rule | P2-F-CQ-009 |
| G-NOTIF-02 | Same-page AJAX feedback type undefined | P2-F-CQ-009 |
| G-NOTIF-03 | Callout / persistent notice concept absent | P2-F-CQ-009 |
| G-NOTIF-04 | High-contrast vs low-contrast notification distinction | P2-F-CQ-009 |
| G-NOTIF-05 | Notification inbox vs toast routing rule absent | P2-F-CQ-009 |
| G-BADGE-01 | Badge color semantic mapping not explicit | P2-F-CQ-009 |
| G-BADGE-02 | Interactive badge/tag variant boundary absent | P2-F-CQ-009 |
| G-BADGE-03 | Badge indicator (dot, count) not documented | P2-F-CQ-009 |
| G-BADGE-04 | WCAG non-text contrast not explicitly linked | P2-F-CQ-009 |
| G-FORM-01 | Required vs optional marking strategy undefined | P2-F-CQ-010 |
| G-FORM-02 | Warning field state not referenced | P2-F-CQ-010 |
| G-FORM-03 | Helper text replacement on error not documented | P2-F-CQ-010 |
| G-FORM-04 | Inline vs summary validation trigger undefined | P2-F-CQ-010 |
| G-SEL-01 | No checkbox vs radio vs toggle usage boundary | P2-F-CQ-010 |
| G-SEL-02 | No select vs combo box vs multi-select rule | P2-F-CQ-010 |
| G-SEL-03 | Selectable tags as selection input not addressed | P2-F-CQ-010 |
| G-STARTERS-01 | No discoverable starter catalog entry point | P2-F-CQ-007 |
| G-STARTERS-02 | No concrete starter page examples | P2-F-CQ-002 through P2-F-CQ-005 |
| G-STARTERS-03 | No blocked/empty/unavailable starter | P2-F-CQ-005 |
| G-TABLE-01 | No documented table variant selection rule | P2-F-CQ-011 |
| G-TABLE-02 | Inline overflow menu threshold rule absent | P2-F-CQ-011 |
| G-TABLE-03 | Skeleton loading for tables not addressed | P2-F-CQ-011 |
| G-PAGIN-01 | Pagination vs pagination-nav selection rule absent | P2-F-CQ-011 |
| G-PAGIN-02 | Page size default and size-pairing rule undocumented | P2-F-CQ-011 |
| G-TABS-01 | No line vs contained vs vertical tab selection rule | P2-F-CQ-011 |
| G-TABS-02 | Automatic vs manual tablist behavior undocumented | P2-F-CQ-011 |
| G-MODAL-01 | No modal variant selection rule | P2-F-CQ-011 |
| G-MODAL-02 | Focus-trap requirement not documented | P2-F-CQ-011 |
| G-MODAL-03 | Modal vs full page selection rule absent | P2-F-CQ-011 |
| G-TOOLTIP-01 | Tooltip vs toggletip usage boundary not documented | P2-F-CQ-011 |
| G-TOOLTIP-02 | Definition tooltip use case not addressed | P2-F-CQ-011 |
| G-LOAD-01 | Loading indicator vs skeleton state selection rule absent | P2-F-CQ-011 |
| G-LOAD-02 | Full-page overlay vs inline loading selection undocumented | P2-F-CQ-011 |
| G-SEARCH-01 | Global vs page vs component-level search scope rule absent | P2-F-CQ-011 |
| G-SEARCH-02 | Search vs filter pattern distinction undocumented | P2-F-CQ-011 |
| G-INPUT-01 | Default vs fluid input styling choice undocumented | P2-F-CQ-011 |
| G-INPUT-02 | Warning state for dropdown and text inputs not addressed | P2-F-CQ-011 |
| G-OVERFLOW-01 | Inline action vs overflow menu threshold rule absent | P2-F-CQ-011 |
| G-OVERFLOW-02 | Destructive action placement in overflow menu undocumented | P2-F-CQ-011 |
| G-BREADCRUMB-01 | No breadcrumb vs progress indicator selection rule | P2-F-CQ-011 |
| G-BREADCRUMB-02 | Breadcrumb overflow/truncation behavior not documented | P2-F-CQ-011 |
| G-STRLIST-01 | No structured list vs data table selection rule | P2-F-CQ-011 |
| G-STRLIST-02 | Selectable structured list vs radio group selection rule absent | P2-F-CQ-011 |
| G-FILEUP-01 | No file uploader variant selection rule (button vs drag-and-drop) | P2-F-CQ-011 |
| G-FILEUP-02 | File uploader size pairing with form fields not documented | P2-F-CQ-011 |
| G-DATEPICK-01 | No date picker variant selection rule (simple vs calendar vs time) | P2-F-CQ-011 |
| G-DATEPICK-02 | Date format display and locale guidance not documented | P2-F-CQ-011 |
| G-GRID-01 | No gutter mode selection rule for page layout contexts | P2-F-CQ-011 |
| G-GRID-02 | No grid style model guidance for Login App 2.0 | P2-F-CQ-011 |
| G-TILE-01 | No tile variant selection rule (base vs clickable vs selectable vs expandable) | P2-F-CQ-011 |
| G-TILE-02 | Tile vs card distinction not documented | P2-F-CQ-011 |

---

## Related

- [Phase 2 Batch F - Starter Catalog Matrix](Phase%202%20Batch%20F%20-%20Starter%20Catalog%20Matrix.md)
- [Tier 1 - Buttons And Icon Buttons Contract](../../02-standards/ui/contracts/Tier%201%20-%20Buttons%20And%20Icon%20Buttons%20Contract.md)
- [Tier 1 - Toast And Inline Alert Contract](../../02-standards/ui/contracts/Tier%201%20-%20Toast%20And%20Inline%20Alert%20Contract.md)
- [Tier 1 - Badges And Status Contract](../../02-standards/ui/contracts/Tier%201%20-%20Badges%20And%20Status%20Contract.md)
- [UI Design System Standards](../../02-standards/ui/UI%20Design%20System%20Standards.md)
- [Phase 2 - Implementation Batch F](../../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%20F.md)
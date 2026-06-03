# Phase 2 Batch F - Starter Catalog Matrix

## Purpose

Provide the authoritative starter catalog matrix for all required Batch F starter-page examples. This matrix maps each required starter to its intended use, shell family, primary Tier 2 patterns, required states, planned UI Reference route, live proof surface, and owning queue item.

Implementation agents working on any of P2-F-CQ-002 through P2-F-CQ-005 must use this matrix as the specification source for their assigned starter.

## How To Use

1. Find the row matching the starter you are implementing.
2. Confirm the shell family and primary Tier 2 patterns with the Shell Family Rule Matrix and Tier 2 checklists.
3. Implement the required states listed in the matrix.
4. Register the UI Reference route.
5. Validate against the live proof surface listed.
6. Refer to the owning queue item for acceptance criteria.

---

## Starter Catalog Matrix

| Starter | Intended Use | Shell Family | Primary Tier 2 Patterns | Required States | UI Reference Route | Live Proof Surface | Owner Queue Item |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Module Home / Module Overview | Entry surface for a feature module; shows module summary, primary stats, and next-action guidance | App shell | Page Title And Actions Row; Content Section Block; Stat Card; Widget Shell | default; empty (no data yet); loading skeleton | `/platform/ui-reference/patterns/starters/module-home` | `/dashboard` (closest analog) | P2-F-CQ-002 |
| Dashboard / Module Summary | Staff overview surface; hosts widget grid, stat cards, and module summary widgets in the dashboard shell | Dashboard shell | Page Title And Actions Row; Dashboard Grid; Widget Shell; Stat Card | default; empty; widget-error fallback | `/platform/ui-reference/patterns/starters/dashboard-summary` | `/dashboard` | P2-F-CQ-002 |
| Dashboard Widget Examples By Content Type | Widget size reference by content type (stat, list, chart, operational); demonstrates approved content-type variations per size | Dashboard shell | Widget Shell; Stat Card; Data List Item | default per size variant | `/platform/ui-reference/patterns/widget-content/{size}` (existing) | `/platform/ui-reference/patterns/widget-content` | P2-F-CQ-002 |
| Settings Page | Per-section settings form; scoped to one settings area with navigation to sibling sections | Settings shell | Page Title And Actions Row; Sub-navigation Bar; Form Section; Form Group; Form Actions Bar; Validation Summary | default; validation error; saved (inline confirmation) | `/platform/ui-reference/patterns/starters/settings` | `/platform/settings/general` | P2-F-CQ-003 |
| Setup / Configuration Page | Task-oriented setup or registration surface; peer-entry structure for configuration steps | Setup shell | Page Title And Actions Row; Content Section Block; Form Section; Form Group; Form Actions Bar | default; step-incomplete; step-done | `/platform/ui-reference/patterns/starters/setup` | `/platform/setup/*` | P2-F-CQ-003 |
| Account / Profile Read-Only | Identity summary and key-value detail; read-only personal or account data surface | Account/profile shell | Page Title And Actions Row; Identity Summary Card; Key Value Display; Content Section Block | default; empty-field fallback | `/platform/ui-reference/patterns/starters/account-read-only` | `/account` | P2-F-CQ-004 |
| Account / Profile Editable | Editable preferences or account settings; settings-style form within the account shell | Account/profile shell | Page Title And Actions Row; Form Section; Form Group; Inline Form Row; Form Actions Bar; Validation Summary | default; editing; validation error; saved | `/platform/ui-reference/patterns/starters/account-editable` | `/account/settings`, `/account/preferences` | P2-F-CQ-004 |
| List / Index | Standard operational list with search, filter, table, and empty state | App shell | Page Title And Actions Row; Search And Filter Bar; Enhanced Data Table; Empty State | default; search-active; filter-active; empty; loading | `/platform/ui-reference/patterns/starters/list-index` | `/platform/ui-reference/patterns/tables` (existing reference) | P2-F-CQ-005 |
| Table Management Index | Operator-oriented table with row actions, bulk-select posture, and filter controls | App shell | Page Title And Actions Row; Search And Filter Bar; Enhanced Data Table; Data List Item | default; row-selected; bulk-action-active; empty | `/platform/ui-reference/patterns/starters/table-management` | `/platform/audit-logs`, `/platform/error-logs` | P2-F-CQ-005 |
| Operational Log / Detail | Diagnostic read-only surface for system or audit log data with hierarchical detail | App shell | Page Title And Actions Row; Content Section Block; Key Value Display; Data List Item | default; empty; drawer-open | `/platform/ui-reference/patterns/starters/operational-log` | `/platform/audit-logs`, `/platform/error-logs` | P2-F-CQ-005 |
| Content Browser / Split View | List and detail browsing structure; selecting a list row reveals a detail panel | App shell | Page Title And Actions Row; Enhanced Data Table or Data List Item; Content Section Block; Drawer or Side Panel | default; row-selected; detail-open; empty | `/platform/ui-reference/patterns/starters/content-browser` | `/platform/ui-reference/audit-logs/{sample}` (existing sample viewer) | P2-F-CQ-005 |
| Detail / Read-Only | Record detail surface; section blocks with key-value pairs and optional supporting list rows | App shell | Page Title And Actions Row; Content Section Block; Key Value Display; Data List Item | default; empty-section | `/platform/ui-reference/patterns/starters/detail-read-only` | `/account` (secondary analog) | P2-F-CQ-005 |
| Create / Edit Form | Generic create or edit flow; form sections with inline validation and a form actions bar | App shell | Page Title And Actions Row; Validation Summary; Form Section; Form Group; Inline Form Row; Form Actions Bar | default; validation-error; submitting | `/platform/ui-reference/patterns/starters/create-edit-form` | `/platform/settings/general`, `/account/settings` | P2-F-CQ-005 |
| Blocked / Empty / Unavailable | Fallback state for permission-blocked, no-data, and unavailable surfaces; demonstrates all three sub-types | App shell (inherited from host archetype) | Empty State; Page Title And Actions Row; Content Section Block | permission-blocked; no-data; service-unavailable; search-no-results | `/platform/ui-reference/patterns/starters/empty-unavailable` | Inline with list, form, and detail starters | P2-F-CQ-005 |

---

## Starter Catalog Entry Point

The starter catalog must be reachable from `/platform/ui-reference` navigation under a dedicated "Starters" section.

- **Route:** `/platform/ui-reference/patterns/starters`
- **Owner:** P2-F-CQ-007

This index page must:
- list all starters by archetype grouping
- provide a brief description and a direct link to each concrete starter view
- link to the archetype matrix (`/platform/ui-reference/patterns/archetypes`) for vocabulary context
- be included in the top-level UI Reference navigation alongside components and patterns

---

## Notes For Implementing Agents

1. **All `/platform/ui-reference/patterns/starters/*` routes are planned routes.** They do not exist yet. P2-F-CQ-007 owns the catalog index and navigation entry. P2-F-CQ-002 through P2-F-CQ-005 own the individual starter views.

2. **Dashboard Widget Examples already have existing routes.** `/platform/ui-reference/patterns/widget-content/{size}` routes are active. P2-F-CQ-002 should validate and expand these rather than creating duplicate routes. The "Dashboard Widget Examples" row in this matrix targets the existing sub-pages.

3. **Proof surfaces are validation references, not implementation constraints.** Implementing a starter at `/platform/ui-reference/patterns/starters/*` does not modify the behavior of the proof surface route. The proof surface is where a comparable real view already exists for cross-reference.

4. **The archetype matrix is vocabulary; this matrix is the catalog.** The [Page And Module Archetype Matrix](Phase%202%20Batch%20B%20-%20Page%20And%20Module%20Archetype%20Matrix.md) defines the 7 archetypes in abstract terms. This starter catalog matrix translates those archetypes into the 14 concrete starters with specific implementation expectations.

5. **Blocked/empty/unavailable sub-types must all appear in one starter.** The three sub-types (permission-blocked, no-data, service-unavailable) should be demonstrated as distinct variants within the same starter view so that a single UI Reference route covers all three cases.

---

## Related

- [Phase 2 Batch F - Carbon Contrast Audit Findings](Phase%202%20Batch%20F%20-%20Carbon%20Contrast%20Audit%20Findings.md)
- [Phase 2 Batch B - Page And Module Archetype Matrix](Phase%202%20Batch%20B%20-%20Page%20And%20Module%20Archetype%20Matrix.md)
- [Phase 2 Batch B - Internal Shell Family Rule Matrix](Phase%202%20Batch%20B%20-%20Internal%20Shell%20Family%20Rule%20Matrix.md)
- [Phase 2 - Implementation Batch F](../../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%20F.md)

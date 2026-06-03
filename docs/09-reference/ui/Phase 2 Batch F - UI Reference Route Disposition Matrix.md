# Phase 2 Batch F - UI Reference Route Disposition Matrix

## Purpose

Define how existing UI Reference routes should be kept, updated, re-homed, or extended during Batch F. This bridges the Carbon contrast audit and starter catalog matrix to the actual route/view work so implementation agents do not make ad hoc decisions.

## Use

Use this matrix before implementing P2-F-CQ-002 through P2-F-CQ-011.

- Keep routes that already serve a stable Tier 1 or Tier 2 proof surface.
- Update routes when the audit found missing usage guidance or state examples.
- Add new starter routes only under `/platform/ui-reference/patterns/starters/*`.
- Do not duplicate existing widget-content routes; extend them where P2-F-CQ-002 requires dashboard widget starter coverage.
- Treat proof surfaces as validation references, not as implementation targets unless their owning CQ explicitly says to update them.

## Route Disposition Matrix

| Route | Current Purpose | Disposition | Required Action | Owner |
| --- | --- | --- | --- | --- |
| `/platform/ui-reference` | Overview workspace | Update | Keep as workspace overview; add starter catalog link only if later navigation density needs a dashboard tile. | P2-F-CQ-007 |
| `/platform/ui-reference/components/actions` | Buttons and icon buttons | Update | Keep current examples; add variant/action-label usage rules under P2-F-CQ-008. | P2-F-CQ-008 |
| `/platform/ui-reference/components/status` | Badges and status | Update | Keep current primitives; expand color semantics and status indicator examples under P2-F-CQ-009. | P2-F-CQ-009 |
| `/platform/ui-reference/components/forms` | Input and form primitives | Update | Keep primitives; expand required/optional, warning, selection, and field-state guidance under P2-F-CQ-010. | P2-F-CQ-010 |
| `/platform/ui-reference/patterns/forms` | Form patterns | Update | Keep as Tier 2 form pattern surface; consume standards from P2-F-CQ-010 before starter form pages are built. | P2-F-CQ-010 |
| `/platform/ui-reference/patterns/data-content` | Data and content patterns | Update | Keep as Tier 2 surface; add structured list, tile/card, and read-only data guidance under P2-F-CQ-011. | P2-F-CQ-011 |
| `/platform/ui-reference/patterns/tables` | Table baselines | Update | Keep as table proof surface; add table variant, skeleton loading, pagination, overflow, and list/index starter references. | P2-F-CQ-011 |
| `/platform/ui-reference/patterns/overlays-feedback` | Overlays and feedback | Update | Keep as feedback proof surface; expand alert/toast and modal guidance under P2-F-CQ-009 and P2-F-CQ-011. | P2-F-CQ-009 / P2-F-CQ-011 |
| `/platform/ui-reference/patterns/navigation` | Navigation and actions | Update | Keep navigation patterns; add breadcrumb, tabs, search/filter, overflow, and action-label guidance. | P2-F-CQ-008 / P2-F-CQ-011 |
| `/platform/ui-reference/patterns/layout` | Layout and dashboard | Update | Keep dashboard/layout proof; add grid guidance and link module/dashboard starters. | P2-F-CQ-002 / P2-F-CQ-011 |
| `/platform/ui-reference/patterns/widget-content` | Widget content standards | Keep and extend | Retain as existing dashboard widget starter family; P2-F-CQ-002 validates and extends without duplicate routes. | P2-F-CQ-002 |
| `/platform/ui-reference/patterns/widget-content/{size}` | Widget size examples | Keep and extend | Retain as concrete widget content examples; add content-type variants only where needed. | P2-F-CQ-002 |
| `/platform/ui-reference/patterns/archetypes` | Archetype vocabulary proof | Keep | Keep as vocabulary context; do not treat as concrete starter catalog after `/patterns/starters` exists. | P2-F-CQ-007 |
| `/platform/ui-reference/patterns/starters` | Starter catalog index | Add | Starter discovery, owner routing, and route disposition matrix. | P2-F-CQ-007 |
| `/platform/ui-reference/patterns/starters/module-home` | Planned concrete starter | Add | Add Module Home / Module Overview starter. | P2-F-CQ-002 |
| `/platform/ui-reference/patterns/starters/dashboard-summary` | Planned concrete starter | Add | Add Dashboard / Module Summary starter. | P2-F-CQ-002 |
| `/platform/ui-reference/patterns/starters/settings` | Planned concrete starter | Add | Add Settings Page starter. | P2-F-CQ-003 |
| `/platform/ui-reference/patterns/starters/setup` | Planned concrete starter | Add | Add Setup / Configuration Page starter. | P2-F-CQ-003 |
| `/platform/ui-reference/patterns/starters/account-read-only` | Planned concrete starter | Add | Add Account / Profile Read-Only starter. | P2-F-CQ-004 |
| `/platform/ui-reference/patterns/starters/account-editable` | Planned concrete starter | Add | Add Account / Profile Editable starter. | P2-F-CQ-004 |
| `/platform/ui-reference/patterns/starters/list-index` | Planned concrete starter | Add | Add List / Index starter. | P2-F-CQ-005 |
| `/platform/ui-reference/patterns/starters/table-management` | Planned concrete starter | Add | Add Table Management Index starter. | P2-F-CQ-005 |
| `/platform/ui-reference/patterns/starters/operational-log` | Planned concrete starter | Add | Add Operational Log / Detail starter. | P2-F-CQ-005 |
| `/platform/ui-reference/patterns/starters/content-browser` | Planned concrete starter | Add | Add Content Browser / Split View starter. | P2-F-CQ-005 |
| `/platform/ui-reference/patterns/starters/detail-read-only` | Planned concrete starter | Add | Add Detail / Read-Only starter. | P2-F-CQ-005 |
| `/platform/ui-reference/patterns/starters/create-edit-form` | Planned concrete starter | Add | Add Create / Edit Form starter. | P2-F-CQ-005 |
| `/platform/ui-reference/patterns/starters/empty-unavailable` | Planned concrete starter | Add | Add Blocked / Empty / Unavailable starter. | P2-F-CQ-005 |
| `/platform/ui-reference/audit-logs/{sample}` | Audit JSON sample route | Keep as support route | Use only as sample payload/proof support for operational-log and content-browser starters. | P2-F-CQ-005 |
| `/platform/ui-reference/error-logs/{sample}` | Error JSON sample route | Keep as support route | Use only as sample payload/proof support for operational-log starters. | P2-F-CQ-005 |

## Related

- [Phase 2 Batch F - Carbon Contrast Audit Findings](Phase%202%20Batch%20F%20-%20Carbon%20Contrast%20Audit%20Findings.md)
- [Phase 2 Batch F - Starter Catalog Matrix](Phase%202%20Batch%20F%20-%20Starter%20Catalog%20Matrix.md)
- [Phase 2 Batch B - Page And Module Archetype Matrix](Phase%202%20Batch%20B%20-%20Page%20And%20Module%20Archetype%20Matrix.md)

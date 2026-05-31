# Phase 2 Batch B - Page And Module Archetype Matrix

## Purpose

Capture the reusable internal page and module archetypes that later phases should consume instead of inventing new page structure ad hoc.

This is a support artifact only.

## Archetype Matrix

| Archetype | Required structure | Primary Tier 2 patterns | Proof surfaces |
| --- | --- | --- | --- |
| Dashboard / overview | page-title/actions row, dashboard grid, section blocks, widget/stat shells | Page Title And Actions Row, Dashboard Grid, Stat Card, Content Section Block | `/dashboard`, `/platform/ui-reference/patterns/layout`, `/platform/ui-reference/patterns/archetypes` |
| List / index | page-title/actions row, search/filter bar, enhanced table or data-list surface, empty state fallback | Page Title And Actions Row, Search And Filter Bar, Enhanced Data Table, Data List Item, Empty State | `/platform/ui-reference/patterns/tables`, `/platform/ui-reference/patterns/navigation`, `/platform/ui-reference/patterns/archetypes` |
| Detail / read-only | page-title/actions row, section block, key-value display, optional supporting list rows | Page Title And Actions Row, Content Section Block, Key Value Display, Data List Item | `/account`, `/platform/ui-reference/patterns/data-content`, `/platform/ui-reference/patterns/archetypes` |
| Create / edit form | page-title/actions row, optional validation summary, one or more form sections, form actions bar | Page Title And Actions Row, Validation Summary, Form Section, Form Group, Inline Form Row, Form Actions Bar | `/platform/settings/general`, `/account/settings`, `/account/preferences`, `/platform/ui-reference/patterns/forms`, `/platform/ui-reference/patterns/archetypes` |
| Setup / configuration | page-title/actions row, task-entry cards and/or settings-like form sections, clear registration-field grouping | Page Title And Actions Row, Content Section Block, Data List Item, Form Section, Form Actions Bar | `/platform/ui-reference/patterns/archetypes` plus live setup shell pages as follow-up adoption |
| Settings | page-title/actions row, section navigation, form sections, validation summary where applicable, form actions bar | Page Title And Actions Row, Sub-navigation Bar, Form Section, Form Group, Form Actions Bar, Validation Summary | `/platform/settings/general`, `/platform/ui-reference/patterns/navigation`, `/platform/ui-reference/patterns/forms`, `/platform/ui-reference/patterns/archetypes` |
| Account / profile | page-title/actions row, either key-value read-only summary or settings-style form scaffolding | Page Title And Actions Row, Key Value Display, Form Section, Form Actions Bar | `/account`, `/account/settings`, `/account/preferences`, `/platform/ui-reference/patterns/archetypes` |

## Inheritance Rules

1. Start with the archetype before deciding individual page composition.
2. Use Tier 2 patterns as building blocks; do not rebuild shell or section semantics inside feature modules.
3. If a page does not fit an existing archetype, stop and document the gap before improvising new structure.

## Related

- [Phase 2 Batch B - Internal Shell Family Rule Matrix](Phase%202%20Batch%20B%20-%20Internal%20Shell%20Family%20Rule%20Matrix.md)
- [Phase 2 - Batch B Implementation Prep](../../07-planning/phases/phase-2/Phase%202%20-%20Batch%20B%20Implementation%20Prep.md)

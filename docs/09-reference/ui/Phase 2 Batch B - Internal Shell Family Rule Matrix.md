# Phase 2 Batch B - Internal Shell Family Rule Matrix

## Purpose

Capture the reusable internal shell-family rules Batch B leaves behind for later module work.

This is a support artifact only. Canonical standards remain in `02-standards/`, and planning ownership remains in `07-planning/`.

## Shell Family Matrix

| Shell family | Header contract | Navigation contract | Primary content contract | Notes |
| --- | --- | --- | --- | --- |
| App shell | shared page-title/actions row sits inside the route-owned page content, not inside the shell chrome | shell-level nav remains separate from page-level sub-navigation | route content starts with page title/actions row, then section blocks | shell framing stays structural; feature behavior stays outside |
| Dashboard shell | page title/actions row leads the surface | shell nav only; widget-level controls stay local to widgets | dashboard grid hosts stat cards and widget shells | dashboard proof is the first staff-facing summary archetype |
| Setup shell | page title/actions row plus setup task framing | setup shell nav may expose peer setup areas; sub-navigation only where peer sections already exist | task-entry cards, configuration sections, registration fields stay visually distinct | setup remains task-oriented rather than settings-form-heavy |
| Settings shell | page title/actions row followed by section navigation where peer settings sections exist | settings shell nav stays separate from form actions | form sections, validation summary, and form actions bar form the default interior contract | registration fields belong inside explicit settings sections |
| Account/profile shell | page title/actions row leads both read-only and editable surfaces | no extra shell nav required by default; use sub-navigation only if peer account sections expand later | read-only summaries use key-value display; edit surfaces use the settings-style form scaffolding | account/profile should feel like the same internal family, not a separate product |

## Shared Rules

1. Shell chrome owns global navigation and framing only.
2. Page-level actions belong in the page title/actions row, not in the shell chrome.
3. Section blocks own internal grouping and spacing after the page title/actions row.
4. Settings/setup registration content should not be mixed into generic action rows.
5. Shared shell parity should be proven through real dashboard/settings/account consumption plus UI Reference proof pages.

## Proof Surfaces

- `/dashboard`
- `/platform/settings/general`
- `/account`
- `/account/preferences`
- `/platform/ui-reference/patterns/navigation`
- `/platform/ui-reference/patterns/layout`
- `/platform/ui-reference/patterns/archetypes`

## Related

- [Phase 2 - Implementation Batch B](../../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%20B.md)
- [UI UX Contract Rollout Tracker](UI%20UX%20Contract%20Rollout%20Tracker.md)

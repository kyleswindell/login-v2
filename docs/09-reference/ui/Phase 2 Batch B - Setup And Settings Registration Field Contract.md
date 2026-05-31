# Phase 2 Batch B - Setup And Settings Registration Field Contract

## Purpose

Describe the minimum field contract later modules should fill when registering setup entries and settings surfaces.

This is a support artifact for later module planning and implementation.

## Required Registration Fields

### Setup entry fields

Every setup-oriented module entry should declare:

- module key
- entry label
- short operator-facing description
- owner surface (`setup`, `settings`, or both)
- required permission / policy gate
- target route
- dependency note if setup should stay hidden until a prerequisite module is ready

### Settings registration fields

Every settings-oriented registration should declare:

- module key
- settings group label
- page label
- route name
- UI owner
- required permission / policy gate
- archetype (`settings`, `create/edit form`, `detail/read-only`, etc.) when non-default
- whether section navigation is required
- whether registration fields are global defaults, operational controls, or customer-facing visibility controls

## Placement Rules

1. Setup entries are task-entry surfaces, not arbitrary dumping grounds for deep operational controls.
2. Settings pages should inherit the settings archetype by default unless a different archetype is documented first.
3. Registration fields belong inside explicit form sections, not inside page-title action areas.
4. If a module needs both setup and settings surfaces, each entry should still declare its own purpose rather than sharing vague labels.

## Batch B Proof References

- `/platform/settings/general`
- `/platform/ui-reference/patterns/forms`
- `/platform/ui-reference/patterns/navigation`
- `/platform/ui-reference/patterns/archetypes`

## Related

- [Phase 4 - Remaining Core Module Planning](../../07-planning/phases/phase-4/Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
- [Phase 2 Batch B - Page And Module Archetype Matrix](Phase%202%20Batch%20B%20-%20Page%20And%20Module%20Archetype%20Matrix.md)

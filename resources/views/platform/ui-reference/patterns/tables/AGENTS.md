# resources/views/platform/ui-reference/patterns/tables AGENTS.md

## Purpose

Focused partials for the UI Reference table-baseline route.

## Read Order

1. Use `intro.blade.php` for the page summary and enhanced-table framing.
2. Use `workspace.blade.php` for the general operator data-grid example.
3. Use `state-validation.blade.php` for loading and empty-state proof surfaces.
4. Use `audit.blade.php` or `error.blade.php` for log table examples.
5. Use `drawers.blade.php` only for audit/error drawer markup.

## Avoid

- Do not edit the route wrapper `../tables.blade.php` unless layout or included partial order changes.
- Do not read all table partials for a single table section.
- Do not move controller payload logic into Blade partials.

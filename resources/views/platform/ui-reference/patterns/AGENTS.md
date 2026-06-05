# resources/views/platform/ui-reference/patterns AGENTS.md

## Purpose

UI Reference pattern pages and starter surfaces.

## Read Order

1. Open the exact pattern page for the route being changed.
2. For table baselines, read `tables/AGENTS.md` and then only the affected table partial.
3. For widget content shapes, open only the affected file under `widget-content/`.
4. Cross-check Tier 2 pattern standards only for the affected pattern family.

## Avoid

- Do not read every pattern page for one route.
- Do not add Tier 1 primitive behavior here.
- Do not let one page accumulate unrelated pattern families when separate route-backed examples would be clearer.

## Split Guidance

High-value split candidates are `layout.blade.php`, `navigation.blade.php`, `widget-content.blade.php`, and `starters.blade.php` if future work regularly targets one section at a time. `tables.blade.php` is already split into focused partials under `tables/`.

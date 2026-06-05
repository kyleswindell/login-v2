# resources/views/platform/ui-reference AGENTS.md

## Purpose

Rendered UI Reference workspace. This folder owns UI Reference pages, pattern previews, partials, and implementation examples.

## Read Order

1. Use the route or sidebar label to identify the exact Blade file.
2. Open `index/AGENTS.md`, `partials/AGENTS.md`, `components/AGENTS.md`, or `patterns/AGENTS.md` before expanding within that subfolder.
3. Cross-check UI standards only for the tier or component family being touched.

## Avoid

- Do not read every UI Reference pattern file for one route.
- Do not treat demo markup as a reusable primitive unless a component file owns it.
- Do not change UI Reference examples without updating tests or route/sidebar wiring when affected.

## Split Guidance

When a single pattern page contains multiple unrelated component families, prefer splitting into smaller route-backed partials or pages with a route/sidebar index.

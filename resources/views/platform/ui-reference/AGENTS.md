# resources/views/platform/ui-reference AGENTS.md

## Purpose

Rendered UI Reference workspace. This folder owns UI Reference pages, pattern previews, partials, and implementation examples.

## Read Order

1. Use the route or sidebar label to identify the exact Blade file.
2. Run the UI API Standards Preflight before editing a rendered proof surface: identify the primary UI API standard, read its table of contents, read `Related APIs`, token/class/helper usage, accessibility, content, UI Reference requirements, and checklist sections, then open related standards touched by the requested behavior.
3. Open `index/AGENTS.md`, `partials/AGENTS.md`, `components/AGENTS.md`, or `patterns/AGENTS.md` before expanding within that subfolder.
4. Inspect the installed source API and current live example before changing markup, behavior, or sidebar navigation.

## Avoid

- Do not read every UI Reference pattern file for one route.
- Do not treat demo markup as a reusable primitive unless a component file owns it.
- Do not change UI Reference examples without updating tests or route/sidebar wiring when affected.
- Do not treat shared UI Reference shell changes as isolated Blade edits; check the related Navigation, Layout, Motion, Icon, Spacing, Typography, Color, and Theme APIs as applicable.
- Do not run the full `tests/Feature/Platform/PlatformUiReferenceTest.php` file as the default proof for every narrow UI Reference edit. It is broad integration coverage across many routes.
- Do not use route-wide negative assertions for generic HTML such as `<details>` when only one component, partial, or region is under test.

## Validation Guidance

- Start with the named test or `--filter` that covers the changed route, component, partial, or sidebar behavior.
- Use source-level assertions for partial-only prohibitions, such as disallowing native disclosure in the sidebar partial.
- Run the full UI Reference feature file only when the change affects shared catalog data, routes, sidebar lifecycle, generated navigation, cross-route contracts, or a final review gate requires broad regression proof.
- If authenticated browser review is required, verify whether Laravel is serving built assets or Vite hot assets before debugging UI behavior. A stale Vite module should be handled as an environment issue, not as application behavior.
- Before authenticated local browser review, run `php artisan local:ready` or `npm run local:ready`. This owns the local review user and `public/hot` normalization; do not repeat ad hoc hot-file moves, cache busting, or Vite restarts during every UI Reference pass.

## Split Guidance

When a single pattern page contains multiple unrelated component families, prefer splitting into smaller route-backed partials or pages with a route/sidebar index.

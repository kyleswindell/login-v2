# resources/views/platform/ui-reference/partials AGENTS.md

## Purpose

Shared UI Reference partials such as sidebar and navigation fragments.

## Read Order

1. Open only the partial that owns the affected shared UI Reference shell behavior.
2. Run the UI API Standards Preflight for the shell surface before editing: identify the primary Navigation or Layout Pattern standard, read its table of contents and `Related APIs`, then read any related Element/Component standards touched by the change.
3. For sidebar changes, inspect current route wiring, tests, source behavior, and live examples before editing.
4. Cross-check routes and tests when adding or removing sidebar entries.
5. For sidebar-only changes, start validation with the focused UI Reference workspace/sidebar test filter and source-level assertions against this partial.

## Avoid

- Do not update route/sidebar wiring without checking the matching route and test expectations.
- Do not add page-specific markup to shared partials.
- Do not add instant disclosure, custom scrolling, or icon behavior without checking the related Motion, Accessibility, Layout, and Icon requirements.
- Do not run the full UI Reference feature file repeatedly for sidebar-only edits. Run it once at the end only when shared routing/catalog/lifecycle behavior changed or the queue item explicitly requires broad regression coverage.
- Do not assert route-wide absence of generic HTML such as `<details>` for sidebar-only rules; scope those assertions to this partial or a stable sidebar container.
- Before authenticated local browser review, run host Vite with `npm run dev:host`, then run `docker compose exec app php artisan local:ready` instead of manually rewriting `public/hot` or recreating the local review user.

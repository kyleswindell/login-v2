# resources/views/platform/ui-reference/partials AGENTS.md

## Purpose

Shared UI Reference partials such as sidebar and navigation fragments.

## Read Order

1. Open only the partial that owns the affected shared UI Reference shell behavior.
2. Cross-check routes and tests when adding or removing sidebar entries.

## Avoid

- Do not update route/sidebar wiring without checking the matching route and test expectations.
- Do not add page-specific markup to shared partials.

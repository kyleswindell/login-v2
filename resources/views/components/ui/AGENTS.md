# resources/views/components/ui AGENTS.md

## Purpose

Reusable UI Blade components. This folder owns primitives and shared UI components consumed by pages and shared patterns.

## Read Order

1. Open the exact component file being used or changed.
2. For pattern components, read `patterns/AGENTS.md`.
3. Run the UI API Standards Preflight before changing component API or behavior: identify the component standard, read its table of contents, `Related APIs`, token/class/helper usage, accessibility, content, evidence requirements, and checklist sections, then open related Element or Pattern standards when the change touches them.
4. Inspect current consumers and tests before changing public props, slots, state behavior, or data attributes.

## Avoid

- Do not redefine component behavior inside consuming views.
- Do not change component props or slots without updating direct consumers and tests.
- Do not read all components for one primitive fix.
- Do not implement component motion, keyboard behavior, focus management, or token usage without checking the owning standard and related API standards.

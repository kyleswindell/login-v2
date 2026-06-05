# resources/views/components/ui AGENTS.md

## Purpose

Reusable UI Blade components. This folder owns primitives and shared UI components consumed by pages and UI Reference examples.

## Read Order

1. Open the exact component file being used or changed.
2. For pattern components, read `patterns/AGENTS.md`.
3. Cross-check the corresponding UI contract before changing component API or behavior.

## Avoid

- Do not redefine component behavior inside consuming views.
- Do not change component props or slots without updating direct consumers and tests.
- Do not read all components for one primitive fix.

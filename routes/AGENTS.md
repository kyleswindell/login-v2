# routes AGENTS.md

## Purpose

Laravel route registration. This folder owns HTTP route wiring and route grouping.

## Read Order

1. Open the route file that owns the affected URL surface.
2. Follow the route to the controller, closure, or Livewire component.
3. Cross-check feature or runbook docs only when route ownership changes.

## Avoid

- Do not scan unrelated route files for a targeted URL change.
- Do not create route aliases or transitional paths without canonical planning or architecture support.

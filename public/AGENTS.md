# public AGENTS.md

## Purpose

Public web assets and Laravel front-controller entry points.

## Read Order

1. Open the exact public asset or entry file tied to the task.
2. For built assets, trace source changes back to `resources/` rather than editing generated output directly.
3. Cross-check deployment runbooks when public files affect runtime serving behavior.

## Avoid

- Do not scan generated assets for routine source changes.
- Do not edit published build output when the source asset should be changed instead.

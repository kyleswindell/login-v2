# docs/04-features AGENTS.md

## Purpose

Behavior only. This branch owns user-visible and system-visible feature contracts.

## Read Order

1. Read `index.md`.
2. Open only the feature file for the behavior being changed.
3. Use architecture, database, and flow docs only when the feature file links to them or the task crosses those boundaries.

## Avoid

- Do not store schema constraints, execution paths, runbook steps, or roadmap sequencing here.
- Do not inspect unrelated feature contracts during a targeted implementation.

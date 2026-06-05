# docs/06-database AGENTS.md

## Purpose

Schema and constraints only. This branch owns database structure, tenant data boundaries, migrations direction, and feature schema contracts.

## Read Order

1. Read `index.md`.
2. Open `schema.md` or the specific feature contract related to the task.
3. Cross-check feature docs only for behavior that affects data shape.

## Avoid

- Do not store UI behavior, process flows, or planning status here.
- Do not read all feature contracts for a single migration or model change.

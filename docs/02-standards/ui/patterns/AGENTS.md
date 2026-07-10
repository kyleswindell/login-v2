# docs/02-standards/ui/patterns AGENTS.md

## Purpose

Pattern standards only. This folder owns reusable UI composition APIs as flat `patterns/{pattern}.md` files.

Pattern docs define what the pattern composes, which Element APIs it consumes, which Component APIs it owns or coordinates, allowed layout options, state ownership, responsive behavior, prohibited usage, deferred gates, rendered evidence proof requirements, and tests.

## Read Order

1. Read `../index.md` for UI layer navigation.
2. Read `../api-registry.md` to confirm Pattern ownership, disposition, route, and planned sub-API gaps.
3. Read `index.md` for pattern-family navigation.
4. Read `checklist.md` for Pattern standards expectations.
5. Open only the specific `patterns/{pattern}.md` file tied to the task.
6. Read related Component and Element standards only for APIs the Pattern consumes or coordinates.

## Avoid

- Do not redefine primitive Component behavior in Pattern standards.
- Do not place feature-specific workflows here.
- Do not treat one-off page composition as a reusable Pattern without a second consumer or explicit product need.
- Do not store active implementation progress in Pattern standards.
# docs/02-standards/ui/elements AGENTS.md
- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Avoid](#3-avoid)

## 1. Purpose

Foundation Element standards only. This folder owns the installed Element APIs below Components and Patterns: grid, color, icons, pictograms, motion, spacing, themes, typography, and related token behavior.

Element docs define token names, CSS variables, utilities/helpers, theme/state behavior, prohibited usage, UI Reference proof requirements, and tests.

## 2. Read Order

1. Read `../index.md` for UI layer navigation.
2. Read `../api-registry.md` to confirm Element disposition and related planned gaps.
3. Read `index.md` for the Element matrix.
4. Open only the specific `elements/{element}.md` file tied to the task.
5. Read consuming Component or Pattern standards only when the task explicitly touches that consumer.

## 3. Avoid

- Do not place Component variants or Pattern composition rules here.
- Do not redefine Component behavior in Element docs.
- Do not introduce raw values unless they are part of an installed token/API decision.
- Do not copy external design-system values as Login App rules without an explicit app decision.
- Do not store active implementation progress in Element standards.

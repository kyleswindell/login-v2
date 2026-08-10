# docs/02-standards/ui/components AGENTS.md

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Delivery And Review State](#3-delivery-and-review-state)
- [4. Avoid](#4-avoid)

## 1. Purpose

Component standards only.

This folder owns primitive and baseline reusable Component API Contracts as flat `components/{component}.md` files.

Component standards define public Blade/CSS/JavaScript/helper APIs where present, allowed variants/options/modifiers, states, composition boundaries, content and accessibility Contracts, prohibited usage, rendered-evidence requirements, and testing expectations.

They do not own active implementation status or GitHub workflow state.

## 2. Read Order

1. Read `../index.md` for UI layer navigation.
2. Read `../api-registry.md` to confirm API ownership, disposition, route, and planned gaps.
3. Read `index.md` for the Component matrix and page Contract.
4. Read `checklist.md` for Component standards completeness expectations.
5. Open only the specific `components/{component}.md` file tied to the task.
6. Read related Element or Pattern standards only when the Component consumes or coordinates those APIs.
7. Inspect installed source, direct consumers, applicable tests, and rendered evidence before changing a public Component Contract.
8. When current delivery or review state matters, use the governing GitHub issue and GitHub Project state; read additional review evidence only when the issue or applicable standard identifies it.

## 3. Delivery And Review State

GitHub Issues own bounded Component implementation work and acceptance criteria.

GitHub Projects own current workflow status, priority, sequencing, dependencies, and blockers.

Component standards own durable API requirements.

Rendered evidence, accessibility proof, browser proof, and manual visual review remain verification evidence. They must not be used as a substitute task board or status ledger.

## 4. Avoid

- Do not put Pattern composition ownership in Component standards.
- Do not read every Component file when the task targets one Component.
- Do not mix current implementation inventory or Project state with canonical Component Contracts.
- Do not add generic placeholder examples to implemented Component standards.
- Do not create local foundation rules for color, spacing, typography, icons, motion, grid, or themes.
- Do not link to deleted UI UX taxonomy or transitional Contract files.
- Do not change public props, slots, states, keyboard behavior, focus behavior, or accessibility behavior without checking direct consumers and required proof.
- Do not treat browser automation or rendered evidence as manual visual acceptance when specialist review is required.

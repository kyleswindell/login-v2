# docs/02-standards/ui/components AGENTS.md
- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Avoid](#3-avoid)

## 1. Purpose

Component standards only. This folder owns primitive and baseline reusable Component API contracts as flat `components/{component}.md` files.

Component docs define public Blade/CSS/JS/helper APIs where present, allowed variants/options/modifiers, states, composition boundaries, content and accessibility contracts, prohibited usage, deferred gates, rendered evidence proof requirements, and tests.

## 2. Read Order

1. Read `../index.md` for UI layer navigation.
2. Read `../api-registry.md` to confirm API ownership, disposition, route, and planned gaps.
3. Read `index.md` for the Component matrix and page contract.
4. Read `checklist.md` for Component standards completeness expectations.
5. Open only the specific `components/{component}.md` file tied to the task.
6. For current implementation/review progress, read `docs/08-active/ui-implementation-sync.md` and the active queue/worklog.

## 3. Avoid

- Do not put Pattern composition ownership in Component standards.
- Do not read every Component file when the task targets one component.
- Do not mix active implementation inventory with canonical Component contracts.
- Do not add generic placeholder examples to implemented Component standards.
- Do not create local foundation rules for color, spacing, typography, icons, motion, grid, or themes.
- Do not link to deleted UI UX taxonomy or transitional contract files.
# resources/css AGENTS.md

## Purpose

CSS source for the Login 2.0 presentation system, including the primary app stylesheet, reusable UI styling, Tailwind theme-seed overrides, compatibility overrides, and bounded owner-specific presentation styling.

Physical placement under `resources/css/` does not by itself determine application ownership.

## Read Order

1. Read root `AGENTS.md`.
2. Read `resources/AGENTS.md`.
3. Read the issue or authorized task.
4. Read the ownership/section map at the top of `app.css` before opening broad ranges.
5. For Tailwind font or slate seed overrides, read `ui/theme-seed.css`.
6. For reusable UI styling, read the applicable [UI Standard](../../docs/02-standards/ui/index.md) and direct Blade/JavaScript consumers.
7. For build-path questions, check `vite.config.js` and the layout/head asset entrypoint.
8. Inspect the required tests, rendered evidence, and manual visual-review surface before changing a public UI Contract.

## Rules

- Do not add new color, spacing, radius, typography, motion, or Component/Pattern variant tokens without an owning canonical UI standard or explicit accepted issue scope.
- Do not use raw values where an accepted token or API owns the behavior.
- Do not treat compatibility overrides as new canonical Component styling.
- Existing transitional CSS branches may receive bounded maintenance, compatibility, or migration work only when the issue authorizes it.
- Do not move broad CSS sections merely to match target topology; ownership, import/build behavior, compatibility, and verification must be explicit.
- Preserve required CSS file headers and section comments.

## UI And Visual Authority

Codex is not the primary visual design authority.

Do not invent layout, spacing, color, typography, responsive, state, or motion behavior when the governing UI Contract does not decide it.

Automated build/browser success does not replace required manual visual acceptance.

## Verification

When CSS changes, run the exact proof declared by the issue or applicable standards.

Preserve applicable:

- frontend build verification;
- public Component/Pattern states;
- responsive behavior;
- theme behavior;
- accessibility;
- browser behavior;
- rendered evidence;
- manual/specialist visual review.

Do not weaken protected UI Contracts, tests, screenshots/review procedures, or evidence requirements to make a change pass.

## Avoid

- Do not scan all of `app.css` for a localized selector change.
- Do not add one-off styling when an existing token, utility, Component, or Pattern should own it.
- Do not expand transitional branches as target architecture.
- Do not perform unrelated visual cleanup during a bounded issue.
- Do not edit generated public build output when source CSS owns the change.

## Stop Conditions

Stop and report when:

- CSS ownership is unclear;
- the applicable UI Contract is missing or insufficient;
- the change requires unspecified visual design judgment;
- target placement or import ownership is unresolved;
- required build/browser/manual proof cannot be completed;
- a compatibility override cannot be safely removed;
- protected verification would require material revision without accepted authority.

## Related

- [Resources AGENTS](../AGENTS.md)
- [UI Standards Index](../../docs/02-standards/ui/index.md)
- [Repository Architecture](../../docs/03-architecture/repository-architecture.md)
- [UI And Accessibility Testing Standards Index](../../docs/02-standards/testing/ui-and-accessibility/index.md)

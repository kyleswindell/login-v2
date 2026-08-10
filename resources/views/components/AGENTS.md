# resources/views/components AGENTS.md

## Purpose

Routing root for Blade component source under `resources/views/components/`.

This tree contains multiple presentation responsibilities. Physical placement under `components/` does not by itself establish reusable UI ownership.

Use the nearest scoped `AGENTS.md` and canonical UI/owner Contract before editing.

## Read Order

1. Read root `AGENTS.md`.
2. Read `resources/AGENTS.md`.
3. Read the issue or authorized task.
4. Identify the component family and open the nearest scoped instructions:
   - `ui/AGENTS.md` for reusable UI primitives/components;
   - `patterns/AGENTS.md` for reusable Pattern composition;
   - `layouts/AGENTS.md` for application layout components and layout-private fragments.
5. Read the exact Blade component.
6. Read the applicable [UI Standard](../../../docs/02-standards/ui/index.md) when the component is reusable UI.
7. Inspect direct consumers and tests before changing props, slots, public state, data attributes, or composition behavior.
8. Read owner-specific feature/flow documentation when the component is capability- or Module-owned presentation.
9. Preserve required manual visual review for design-sensitive changes.

Do not scan every component family for a localized change.

## Ownership

Reusable UI components:

- render from data and decisions supplied by consumers;
- may own presentation-only state and accessibility behavior;
- must not query persistence or resolve authorization/domain state.

Capability- or Module-specific presentation:

- remains owned by the Core capability or Module whose behavior it presents;
- must not become reusable UI merely because it uses Blade components;
- must consume shared UI Contracts rather than redefining them.

Layout-private adapters may compose reusable UI without becoming public reusable Components themselves.

## Public Contract Changes

Before changing reusable props, slots, variants, states, DOM/data attributes, accessibility behavior, or interaction hooks:

- identify the canonical UI standard;
- inspect direct consumers;
- inspect existing tests and rendered evidence;
- identify required related APIs;
- identify manual/specialist review requirements.

Update the owning standard when the accepted public Contract changes.

Do not silently change a public Component API during a local consumer fix.

## UI And Visual Authority

Codex is not the primary visual design authority.

Do not invent or redesign:

- layout hierarchy;
- spacing;
- color;
- typography;
- iconography;
- motion;
- responsive behavior;
- keyboard/focus behavior;
- interaction structure.

when the accepted UI authority does not specify the change.

Automated rendering or browser proof does not replace required manual visual acceptance.

## Verification

Use the issue's accepted `AC-*` / `PF-*` proof.

For public Component changes, preserve applicable:

- rendering states;
- consumer compatibility;
- accessibility semantics;
- browser behavior;
- CSS/JavaScript integration;
- frontend build;
- manual/specialist review.

Do not weaken protected Contracts, tests, selectors, fixtures, or review procedures to make implementation pass.

## Avoid

- Do not redefine Tier 1 primitives in Patterns or feature views.
- Do not place feature-specific behavior inside shared Components.
- Do not duplicate component logic in consumers.
- Do not treat `resources/views/components/` as one ownership area.
- Do not move routed page behavior into reusable UI.
- Do not perform unrelated visual cleanup during a bounded issue.

## Stop Conditions

Stop and report when:

- component ownership is unclear;
- reusable UI and capability/Module presentation are being conflated;
- the public UI Contract is missing or insufficient;
- the change requires unspecified visual or interaction design;
- direct consumers cannot be identified for a breaking public API change;
- required browser/accessibility/manual review cannot be completed;
- protected verification would require material revision without accepted authority.

## Related

- [Resources AGENTS](../../AGENTS.md)
- [UI Definition](../../../docs/07-planning/Definitions/UI/Definition.md)
- [UI Standards Index](../../../docs/02-standards/ui/index.md)
- [UI And Accessibility Testing Standards Index](../../../docs/02-standards/testing/ui-and-accessibility/index.md)

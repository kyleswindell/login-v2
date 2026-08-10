# app/UI AGENTS.md

## Purpose

Permanent PHP/runtime owner root for reusable Login 2.0 UI responsibilities.

UI ownership is determined by reusable presentation responsibility, not by PHP, Blade, CSS, JavaScript, or `resources/` placement.

Every direct child of `app/UI/` must represent one cohesive reusable UI responsibility. Technical roles remain beneath that responsibility.

## Read Order

1. Read root `AGENTS.md`.
2. Read `app/AGENTS.md`.
3. Read the issue or authorized task.
4. Read the [UI Definition](../../docs/07-planning/Definitions/UI/Definition.md).
5. Read [Repository Architecture](../../docs/03-architecture/repository-architecture.md) when ownership or placement matters.
6. Read the applicable [UI Standards](../../docs/02-standards/ui/index.md).
7. Identify the exact reusable UI responsibility and public Contract before opening source broadly.
8. Inspect direct consumers and applicable tests before changing a public API.
9. Read `resources/AGENTS.md` and the nearest `resources/` instruction file when the change also affects Blade, CSS, or JavaScript source.
10. For proof semantics, accessibility, browser, responsive, or visual review, route through the applicable [UI And Accessibility Testing Standards](../../docs/02-standards/testing/ui-and-accessibility/index.md).

Do not scan unrelated UI responsibilities for a bounded change.

## Ownership

UI may own:

- reusable presentation-only PHP/runtime infrastructure;
- reusable Elements, Components, Patterns, and Layout support;
- presentation-only Contracts and data shapes;
- reusable interaction behavior;
- accessibility behavior intrinsic to reusable UI;
- reusable loading, empty, validation, error, and interaction-state presentation.

UI must not own:

- routed page behavior;
- capability-specific page content or composition;
- authorization or permission resolution;
- database access, domain queries, or mutations;
- Core or Module lifecycle behavior;
- navigation filtering, contribution aggregation, or active-context resolution;
- feature-specific state or workflows.

A routed or capability-specific presentation remains owned by the Core capability or Module whose behavior it presents.

## Dependencies

- UI may depend on Laravel presentation APIs, Blade/browser APIs, and other public UI Contracts.
- Core presentation and Modules may depend on UI.
- UI must not depend on Core or Module domain implementation.
- UI must receive already-resolved labels, URLs, actions, states, and display data from its consumer.
- UI must not query Models, Registries, permissions, routes, or persistence to decide domain behavior.

## Placement

- Keep reusable UI PHP/runtime responsibilities under `app/UI/<Responsibility>/`.
- Keep owner-local tests under `app/UI/<Responsibility>/__tests__/`.
- Keep presentation source in its accepted `resources/` owner.
- Do not move feature-owned views into UI merely because they consume shared Components.
- Do not use current transitional CSS/JavaScript branches as target authority.

## UI And Visual Authority

Codex is not the primary visual design authority.

Before changing a public UI Contract:

- identify the canonical UI standard;
- inspect direct source and consumers;
- identify required states, accessibility, keyboard, motion, responsive, and content behavior;
- identify automated proof;
- preserve required manual or specialist visual review.

Do not infer layout, hierarchy, spacing, color, typography, motion, or interaction design when the accepted UI authority does not decide it.

## Verification

Use the issue's accepted `AC-*` / `PF-*` verification contract.

Do not weaken accepted UI Contracts, tests, fixtures, rendered-evidence procedures, accessibility checks, or specialist-review procedures to make implementation pass.

Automated browser success does not replace required manual visual acceptance.

## Avoid

- Do not make `app/UI/` a generic home for anything rendered to a user.
- Do not place feature behavior or authorization decisions in reusable UI.
- Do not redefine Core or Module data/state inside a UI adapter.
- Do not create one-off UI abstractions without a reusable responsibility.
- Do not redesign unrelated UI during a bounded implementation slice.

## Stop Conditions

Stop and report when:

- reusable UI ownership versus Core/Module presentation ownership is unclear;
- a public UI Contract is missing or insufficient;
- the change requires unspecified visual design judgment;
- accessibility, keyboard, motion, responsive, or browser behavior is unresolved;
- target placement conflicts with Repository Architecture;
- protected verification or review evidence would require material revision without accepted authority.

## Related

- [UI Definition](../../docs/07-planning/Definitions/UI/Definition.md)
- [Repository Architecture](../../docs/03-architecture/repository-architecture.md)
- [UI Standards Index](../../docs/02-standards/ui/index.md)
- [UI And Accessibility Testing Standards Index](../../docs/02-standards/testing/ui-and-accessibility/index.md)
- [Test Implementation Standards Index](../../docs/02-standards/coding/test-implementation/index.md)

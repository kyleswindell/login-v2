# resources AGENTS.md

## Purpose

Presentation source and primary frontend asset entrypoints.

This folder contains Blade views, reusable UI presentation, CSS, JavaScript, and related frontend source. Physical placement under `resources/` does **not** determine application ownership.

- Reusable UI Elements, Components, Patterns, Layouts, and shared UI presentation remain UI-owned.
- Core- or Module-specific URL views remain owned by the Core capability or Module whose behavior they present.
- Reusable presentation must not absorb authorization, persistence, domain queries, mutations, or owner-specific lifecycle behavior.

## Read Order

1. Read the issue or authorized task.
2. Identify whether the affected presentation is reusable UI, Core-owned presentation, or Module-owned presentation.
3. Read the nearest scoped `AGENTS.md`.
4. For UI changes, run the UI API Standards Preflight: identify the primary UI API standard, read its relevant Contract sections, then open related API standards only when the change touches them.
5. Read the exact view, component, script, stylesheet section, direct consumer, and applicable test before expanding.
6. Read [Repository Architecture](../docs/03-architecture/repository-architecture.md) when source placement or ownership changes.
7. For test source, use the [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md).
8. For UI/browser/accessibility proof, use the applicable [Testing Standards](../docs/02-standards/testing/ui-and-accessibility/index.md).

Do not load broad CSS, JavaScript, or component families for a localized change.

## UI API Rules

Before changing a reusable public UI API:

- identify the canonical Element, Component, Pattern, or Layout owner;
- inspect its standard and `Related APIs`;
- inspect direct consumers;
- inspect current tests and rendered evidence;
- identify required variants, states, accessibility, keyboard, motion, content, and responsive behavior;
- identify required manual or specialist review.

Codex is not the primary visual design authority. Do not invent visual hierarchy, layout, spacing, color, typography, motion, or interaction behavior when the governing Contract does not decide it.

## JavaScript

Shared JavaScript behavior should live in concern-based modules under `resources/js/`; keep `resources/js/app.js` as the bootstrap and event-registration entrypoint.

Shared initializer contract:

- initializers accept `root = document` and may be called with either `document` or a subtree;
- initializers are idempotent and mark initialized elements or regions to prevent duplicate listeners;
- initializers are safe on initial page load and `livewire:navigated`;
- initializers must not rely on receiving a DOM event object;
- when registering a new shared initializer, add the focused proof required by the accepted implementation/verification contract.

Do not create a new JavaScript abstraction solely because several unrelated files use JavaScript.

## CSS

`resources/css/app.css` is a large primary entrypoint. Use its section/ownership map and targeted search before broad reads.

Do not add new color, spacing, radius, typography, motion, or component-variant tokens without an owning canonical UI standard or explicit accepted issue scope.

Do not treat compatibility overrides as new canonical component styling.

Split CSS only when build ownership, import behavior, target placement, and verification are explicit.

## Verification

The issue or authorized work packet owns the acceptance criteria and declared proof.

For UI changes, preserve applicable:

- public UI Contract tests;
- rendered states;
- browser behavior;
- keyboard and focus behavior;
- accessibility requirements;
- responsive behavior;
- frontend build;
- manual visual or specialist review.

Do not weaken, skip, delete, or materially rewrite protected proof after the accepted initial baseline.

Automated browser success does not replace required manual visual acceptance.

## Avoid

- Do not treat every file under `resources/` as UI-owned.
- Do not move Core- or Module-specific behavior into reusable UI.
- Do not redefine Tier 1 primitives inside Tier 2 Patterns or feature views.
- Do not implement UI behavior from a local view alone when the owning API standard defines related motion, accessibility, layout, content, or token requirements.
- Do not create new canonical files in transitional CSS/JavaScript branches without accepted scope.
- Do not edit generated build output under `public/` when source under `resources/` owns the change.
- Do not perform broad visual improvements during a bounded implementation slice.

## Stop Conditions

Stop and report when:

- reusable UI ownership versus Core/Module presentation ownership is unclear;
- the public UI Contract is missing or insufficient for a behavior-heavy change;
- the task requires unspecified visual design judgment;
- accessibility, keyboard, motion, responsive, or browser behavior is unresolved;
- target source placement conflicts with Repository Architecture;
- a protected UI test, Contract, or review procedure would require material revision without authority;
- required build/browser/native proof cannot run;
- another writer owns the same shared UI source scope.

## Related

- [Repository Architecture](../docs/03-architecture/repository-architecture.md)
- [UI Standards Index](../docs/02-standards/ui/index.md)
- [UI And Accessibility Testing Standards Index](../docs/02-standards/testing/ui-and-accessibility/index.md)
- [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md)

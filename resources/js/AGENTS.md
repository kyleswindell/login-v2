# resources/js AGENTS.md

## Purpose

Primary application JavaScript entrypoints and current browser-side source under `resources/js/`.

Physical placement here does not by itself establish UI ownership. Reusable interaction controls may be UI-owned; capability- or Module-specific browser behavior remains owned by the responsibility whose behavior it implements.

`app.js` is the main browser bootstrap and lifecycle-registration entrypoint.

## Read Order

1. Read root `AGENTS.md`.
2. Read `resources/AGENTS.md`.
3. Read the issue or authorized task.
4. Open the exact JavaScript module tied to the behavior.
5. Read `app.js` only when bootstrap, imports, or lifecycle registration are affected.
6. For reusable UI behavior, read the applicable [UI Standard](../../docs/02-standards/ui/index.md) and direct consumers.
7. Inspect existing focused tests/source assertions before changing a shared initializer or public DOM Contract.
8. For browser/accessibility proof, route through the applicable [UI And Accessibility Testing Standards](../../docs/02-standards/testing/ui-and-accessibility/index.md).
9. Check the Vite entry/build path when imports or bundling change.

Do not load every initializer for a localized interaction fix.

## Ownership

- Reusable presentation/interaction behavior may be UI-owned.
- Core- or Module-specific state, authorization, workflow, or domain decisions must remain with Core or the Module.
- Module-owned JavaScript should remain with the Module when the accepted package structure provides that owner.
- `resources/js/app.js` coordinates browser startup; it must not become a generic implementation bucket.

## Shared Initializer Contract

Shared lifecycle initializers must:

- accept `root = document` and support `document` or a subtree;
- be idempotent;
- avoid duplicate listener registration;
- remain safe on initial page load and `livewire:navigated`;
- not depend on receiving a DOM event object as the initializer argument;
- preserve the public DOM/data-attribute Contract defined by the owning standard.

When a new shared initializer is registered, add the focused proof required by the accepted implementation/verification contract.

## Transitional Source

Current branches such as:

```text
resources/js/ui-controls/
resources/js/internal/
```

are transitional where Repository Architecture classifies them that way.

Do not treat them as permanent target ownership or create new canonical files there unless a bounded issue explicitly authorizes maintenance, compatibility, or migration work.

## UI And Design Authority

Codex is not the primary visual or interaction-design authority.

Do not invent keyboard behavior, focus management, motion, state transitions, content, or visual interaction when the governing UI Contract does not decide it.

Inspect the applicable UI standard, source, consumers, tests, and required manual/specialist review before changing reusable interaction behavior.

## Verification

Use the issue's accepted `AC-*` / `PF-*` proof.

When JavaScript changes:

- run the required focused browser/source proof;
- run the frontend build when the accepted verification contract requires it;
- preserve required keyboard/accessibility behavior;
- preserve Livewire navigation lifecycle behavior;
- preserve manual visual review when required.

Do not weaken protected selectors, Contracts, tests, fixtures, or review procedures to make implementation pass.

## Avoid

- Do not place domain or authorization decisions in shared JavaScript.
- Do not register duplicate lifecycle listeners.
- Do not add global behavior when a bounded component/Pattern owns it.
- Do not move Module-owned browser behavior into app-global JavaScript for convenience.
- Do not expand transitional branches as new target architecture.
- Do not perform unrelated JavaScript cleanup during a bounded issue.

## Stop Conditions

Stop and report when:

- JavaScript ownership is unclear;
- the applicable UI/public DOM Contract is missing or insufficient;
- the change requires unspecified interaction design;
- target placement conflicts with Repository Architecture;
- required browser/build/native proof cannot run;
- protected verification would require material revision without accepted authority.

## Related

- [Resources AGENTS](../AGENTS.md)
- [UI Standards Index](../../docs/02-standards/ui/index.md)
- [UI And Accessibility Testing Standards Index](../../docs/02-standards/testing/ui-and-accessibility/index.md)
- [Repository Architecture](../../docs/03-architecture/repository-architecture.md)

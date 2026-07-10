# UI Test Requirements

## Purpose

This branch contains implementation-facing UI test requirements only. It keeps required test criteria easy to find without burying them inside long Element, Component, or Pattern standards.

Executable tests do not live in this documentation branch. Future executable tests should live beside the owning implementation or in the app test tree:

- `resources/views/elements/{element}/__tests__/`
- `resources/views/components/ui/{component}/__tests__/`
- `owner-specific feature tests`
- `tests/Unit/Ui/`

These paths are documented as future or expected ownership paths. Do not create these directories or executable tests from this checklist alone.

## Requirement Model

UI requirements use two test concepts:

- Adopted Carbon parity verifies only the Carbon roles, token families, values, component concepts, or behavior that Login App explicitly adopted.
- Login App governance verifies app consumers do not bypass approved Element, Component, or Pattern APIs with raw values, unapproved local tokens, stale APIs, or local behavior forks.

Element requirements must be completed before broad Component contract rollout. Components verify exact Element consumption. Patterns verify composition-level usage and must not override component-owned internals.

## Status Values

Use only these statuses in requirement matrices and per-surface files:

- `planned`
- `partial`
- `implemented`
- `blocked`
- `deferred`
- `needs-confirmation`

## Requirement Indexes

| Layer | Requirement matrix | Scope |
| --- | --- | --- |
| Foundation Elements | [elements.md](elements.md) | Token/API boundaries, adopted Carbon parity, global CSS governance, rendered evidence proof. |
| Components | [components.md](components.md) | Exact Element consumption, public variants, states, accessibility, behavior, and component examples. |
| Patterns | [patterns.md](patterns.md) | Composition-level Element use, approved Component coordination, route behavior, responsive layout, and workflow proof. |

## Ownership Rules

- This branch copies criteria from canonical UI standards for implementation clarity; it does not own final API behavior.
- Owning standards under `docs/02-standards/ui/elements/`, `components/`, and `patterns/` remain the canonical rules.
- Requirement files may point to known drift, blocked checks, and validation notes, but active implementation state belongs in `docs/08-active/`.
- Do not place test criteria in `docs/02-standards/testing/`.

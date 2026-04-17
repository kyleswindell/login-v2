# Feature Modules Alignment Checklist

This document defines the canonical scope and intent for Feature Modules Alignment Checklist.

## Purpose

Define enforceable architecture guidance for Tier 3 feature modules in the current App 2.0 stack.

This checklist is architecture guidance, not UI standards guidance. It exists to keep Tier 1, Tier 2, and Tier 3 responsibilities aligned to the current repository structure and current canonical docs system.

## Canonical Ownership

- Architecture owns the Tier 3 feature-module boundary and implementation-shape guidance.
- Standards own Tier 1 primitives, Tier 2 reusable patterns, tokens, and UI Reference rules.
- Features own feature behavior and user-visible contracts.

## Tier Model

### Tier 1

Tier 1 owns primitives and baseline structural shells.

Canonical owner:

- [UI UX Component Taxonomy And Coverage Matrix](../02-standards/ui/components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [Tier 1 Component Implementation Checklist](../02-standards/ui/components/Tier%201%20Component%20Implementation%20Checklist.md)

### Tier 2

Tier 2 owns reusable patterns composed from Tier 1.

Canonical owner:

- [UI UX Component Library Standards](../02-standards/ui/components/UI%20UX%20Component%20Library%20Standards.md)
- [Tier 2 Pattern Library Checklist](../02-standards/ui/components/Tier%202%20Pattern%20Library%20Checklist.md)

### Tier 3

Tier 3 owns feature-specific composition and feature-specific interaction logic across the current implementation layer.

Normal current-stack Tier 3 implementation shape spans:

- controllers
- Livewire components
- Blade views
- services
- `app/Platform/`
- route registration and feature wiring where applicable

Optional or supporting Tier 3 implementation pieces may include:

- repositories
- form requests
- providers
- other feature-owned implementation pieces where applicable

Tier 3 is a feature layer, not a required single folder or single file shape.

## Composition Rule

Tier 3 composition must follow this rule:

- Tier 3 should prefer canonical Tier 2 patterns where they exist.
- Tier 3 may directly compose Tier 1 primitives when no canonical Tier 2 pattern exists yet.
- Tier 3 must not recreate reusable pattern logic locally when that logic belongs in Tier 2.

## Identification

For each implemented surface or feature doc, confirm:

- [ ] the surface is domain-specific rather than globally reusable
- [ ] the surface uses feature data, state, permissions, or workflow logic
- [ ] the surface belongs to a concrete feature contract in `docs/04-features/`

If those checks pass, treat the surface as Tier 3.

## Current Stack Alignment

Tier 3 implementation must align to the current repo structure described in architecture docs, not to an abstract `/features/<domain>/` rule.

Active current-stack implementation locations include:

- `app/Http/Controllers/Platform/`
- `app/Livewire/Platform/`
- `app/Platform/`
- `resources/views/platform/`
- `resources/views/livewire/platform/`
- route registration and feature wiring where applicable

Optional or supporting implementation pieces include:

- repositories where the feature actually benefits from them
- form requests where request validation warrants them
- providers only where feature wiring or registration genuinely requires them

Validation:

- [ ] the feature module is implemented through current stack-owned layers rather than an invented module folder convention
- [ ] controllers, Livewire, Blade, `app/Platform`, and route wiring remain the normal Tier 3 implementation shape
- [ ] repositories, requests, and providers are treated as optional supporting pieces rather than assumed default structure
- [ ] no Tier 1 or Tier 2 owner docs imply a required runtime folder shape for Tier 3

## Feature-Layer Ownership

Tier 3 owns feature-layer orchestration across its implementation pieces, including where applicable:

- request handling
- feature data loading and persistence orchestration
- feature-specific filtering, sorting, and search behavior
- authorization and RBAC enforcement at the feature boundary
- feature state transitions
- feature-specific UI composition

Validation:

- [ ] feature-layer responsibilities are owned by the feature implementation, not pushed into Tier 2 patterns
- [ ] ownership is distributed across the appropriate implementation pieces rather than implied as one module file
- [ ] Tier 2 remains data-agnostic and feature-agnostic

## Styling Rule

Feature modules may use local layout composition.

Feature modules must not:

- redefine Tier 1 tokens
- redefine Tier 1 primitive styling rules
- redefine reusable Tier 2 pattern styling

Validation:

- [ ] local layout glue is limited to feature composition needs
- [ ] no new token definitions are introduced in feature-owned code
- [ ] reusable pattern styling is not forked locally inside a feature

## Pattern Behavior Rule

Reusable pattern behavior belongs in Tier 2.

Feature-specific interaction logic is allowed in Tier 3.

Validation:

- [ ] reusable interaction behavior that could serve multiple features is not implemented as one-off feature code
- [ ] feature-only interaction logic stays in Tier 3
- [ ] Tier 3 does not modify the internal reusable behavior contract of Tier 2 patterns

## Promotion Rule

Promote feature-owned UI logic or structure to Tier 2 when it becomes:

- reusable
- parameterizable
- no longer domain-specific

Validation:

- [ ] promotion candidates are identified qualitatively rather than by a fixed usage count
- [ ] promoted logic is removed from the feature layer once a canonical Tier 2 pattern exists
- [ ] Tier 2 owner docs are updated when promotion occurs

## UI Reference Boundary

UI Reference is limited to Tier 1 and Tier 2.

Canonical UI owner docs:

- [UI Design System Standards](../02-standards/ui/UI%20Design%20System%20Standards.md)
- [UI UX Component Library Standards](../02-standards/ui/components/UI%20UX%20Component%20Library%20Standards.md)
- [Tier 1 Component Implementation Checklist](../02-standards/ui/components/Tier%201%20Component%20Implementation%20Checklist.md)
- [Tier 2 Pattern Library Checklist](../02-standards/ui/components/Tier%202%20Pattern%20Library%20Checklist.md)

Validation:

- [ ] feature modules do not live in UI Reference
- [ ] UI Reference contains only Tier 1 and Tier 2 surfaces
- [ ] feature modules consume the UI system rather than defining canonical UI behavior there

## Anti-Drift Validation

- [ ] Tier 3 prefers canonical Tier 2 patterns where they exist
- [ ] Tier 3 may compose Tier 1 directly only when no canonical Tier 2 pattern exists yet
- [ ] Tier 3 does not recreate reusable Tier 2 pattern logic locally
- [ ] Tier 3 does not create new Tier 1 primitives
- [ ] Tier 3 does not redefine Tier 1 tokens or reusable pattern styling
- [ ] Tier 3 ownership matches the current Laravel, Livewire, Blade, and support-layer structure

## Final Status

Use this checklist to declare a Tier 3 feature module aligned only when the composition rule, current-stack structure rule, and ownership boundaries all pass together.

## Related

- [Architecture Index](index.md)
- [Application Structure](subsystems/application-structure.md)
- [Current Repo Structure](subsystems/current-repo-structure.md)
- [Features Index](../04-features/index.md)

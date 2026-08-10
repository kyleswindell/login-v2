# docs/02-standards/ui AGENTS.md

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. UI API Standards Preflight](#3-ui-api-standards-preflight)
- [4. Delivery And Review State](#4-delivery-and-review-state)
- [5. Installed Source And Target Topology](#5-installed-source-and-target-topology)
- [6. Avoid](#6-avoid)
- [7. Split Rule](#7-split-rule)

## 1. Purpose

UI standards only.

This folder owns final Login App UI API expectations for Foundation Elements, Components, Patterns, and the stable UI API inventory.

Standards define public API Contracts, allowed tokens/classes/helpers/components, supported variants/options/states, prohibited usage, deferred gates, rendered evidence requirements, accessibility expectations, and testing expectations.

Standards do not own current implementation status, GitHub workflow state, or chronological worklogs.

## 2. Read Order

1. Read `index.md` for UI standards navigation.
2. Read [Repository Architecture](../../03-architecture/repository-architecture.md) when work changes physical source placement, creates a new UI source file, or touches a transitional CSS or JavaScript branch.
3. Read `api-registry.md` to confirm API ownership, disposition, route, source surface, and planned gaps.
4. For Foundation Elements, read `elements/index.md` and then the specific `elements/{element}.md` standard.
5. For Components, read `components/index.md` and then the specific `components/{component}.md` standard.
6. For Patterns, read `patterns/index.md`, `patterns/checklist.md`, and only the relevant `patterns/{pattern}.md` standard.
7. For color/theme token work, read `elements/color.md`, `elements/themes.md`, and `api-registry.md` for the current token ownership map.
8. When current delivery or review state matters, use the governing GitHub issue and GitHub Project state. Read review evidence only when the issue or applicable standard identifies that evidence surface.

Do not load the entire UI standards family for a narrow API change.

## 3. UI API Standards Preflight

Before any UI source or rendered-evidence edit:

1. identify the primary UI API standard for the artifact being changed;
2. read that standard's table of contents;
3. read applicable sections for:
   - `Related APIs`;
   - token, class, and helper usage;
   - accessibility;
   - content;
   - rendered evidence;
   - implementation and verification checklists;
4. open related API standards only when the requested change touches those dependencies;
5. inspect installed source behavior, direct consumers, applicable tests, and current rendered evidence before changing a public UI Contract;
6. verify whether the requested source destination is permanent, transitional, or compatibility-only under Repository Architecture.

For example, sidebar-navigation work must check the applicable Navigation or Layout Pattern standard plus related Motion, Icons, Spacing, Typography, Color, and Theme Element standards when those APIs are affected.

If the primary standard and its related APIs do not define enough behavior for a behavior-heavy UI change, stop rather than inventing local behavior.

For an implementation issue, record the applicable UI authority, required states, accessibility behavior, browser scope, rendered-evidence requirements, and manual/specialist review in the issue's accepted verification and review contract.

## 4. Delivery And Review State

GitHub Issues own bounded UI implementation work and acceptance criteria.

GitHub Projects own current workflow status, priority, sequencing, dependencies, and blockers.

Canonical UI standards own durable UI API requirements.

Rendered evidence, browser proof, accessibility evidence, and manual visual review must be stored or referenced according to the applicable UI and Testing standards. They do not become delivery-state ledgers.

Do not create or revive a documentation queue or worklog as a parallel task board.

## 5. Installed Source And Target Topology

Physical source paths recorded in UI standards describe installed implementation unless explicitly labeled as target structure.

The following parallel source trees are transitional under Repository Architecture:

```text
resources/css/components/
resources/css/patterns/
resources/css/tokens/
resources/css/type/
resources/css/ui/
resources/js/ui-controls/
resources/js/internal/
```

References to those paths remain valid current-source inventory until an accepted migration moves the implementation and updates the owning standard in the same change.

Installed source paths do not authorize those branches as permanent target ownership or as destinations for new canonical files.

Existing files in transitional branches may receive bounded maintenance, compatibility, or migration work only when the governing issue explicitly authorizes it.

## 6. Avoid

- Do not read every UI standard by default.
- Do not treat reference or audit material as rules unless this standards folder adopts the rule.
- Do not store current implementation status, Project state, queue state, or chronological worklogs in UI standards.
- Do not add generic placeholder examples to implemented API standards.
- Do not write abstract design essays where an installed API Contract is required.
- Do not reintroduce deleted transitional `contracts/` or stale UI UX component/taxonomy files.
- Do not edit UI source from memory when the relevant UI API standard has `Related APIs` and checklist sections available.
- Do not interpret installed source paths in UI standards as permanent target topology.
- Do not create new canonical files in transitional parallel CSS or JavaScript trees unless the governing issue explicitly authorizes bounded compatibility or migration work.
- Do not move existing UI source solely to satisfy target topology before placement, naming, migration, and verification authority is accepted.
- Do not treat automated browser or rendered-evidence proof as manual visual acceptance when specialist review is required.

## 7. Split Rule

Keep canonical UI standards flat by default:

- `elements/{element}.md`;
- `components/{component}.md`;
- `patterns/{pattern}.md`.

Split a single standard into focused child pages only when responsibilities are genuinely separable or the current file has become difficult to retrieve, review, or maintain reliably.

Line count alone does not require a split.

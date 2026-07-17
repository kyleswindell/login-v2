<!--
DOC-META
title: Phase 6.8 Model Acceptance And Corrections
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-8-model-acceptance-and-corrections.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the provisional Phase 6 result, representative-example classifications, bounded corrections, later-owner decisions, and Phase 7 handoff.
-->

# Phase 6.8 Model Acceptance And Corrections

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Determine whether the accepted Goal 3 repository model can represent the four Phase 6 examples without unresolved structural ambiguity.

This is a first draft for repository-owner review. It does not record final acceptance.

## 2. Status

- Planning lifecycle: draft
- Acceptance state: pending repository-owner Phase 6 review
- Implementation state: validation conclusion only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Depends on: Phases 6.1 through 6.7 and Phase 6.90
- Blocking proposal: ADR-0008 must be accepted, revised, or rejected before final Phase 6 acceptance
- Repository reconciliation: deferred until the end of Phase 6 and Goal 3 alignment

## 3. Representative Results

| Example                          | Provisional classification                            | Finding                                                                                                                                           |
| -------------------------------- | ----------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Settings                         | Fits without structural exception                     | Required Core capability, Settings Host, and Navigation Contributor roles remain distinct                                                         |
| Projects                         | Fits without structural exception                     | Optional package owns its behavior and contributes Product navigation through Core Contracts                                                      |
| Modal and Dialog                 | Fits with migration work only                         | Target UI artifact ownership is clear; current parallel asset and stale Surface dependencies are transitional                                     |
| Sidebar Navigation Frame Surface | Fits under the bounded Workspace and Frame correction | Core Navigation hosts resolution, Workspaces supply Product scope, Contributors retain declarations, Access evaluates permissions, and UI renders |

## 4. Bounded Corrections

### 4.1. Workspace Cardinality

A User Account may have access to multiple named Workspaces, with one active Workspace in the rendered context.

This changes the earlier assumption that Global Administration is merely a broad Surface inside one indivisible Workspace.

### 4.2. Surface Meaning

The broad owner-specific page, destination, area, or flow meaning of Surface is replaced by the narrower **Frame Surface** concept.

A Frame Surface is a named compositional region of the persistent Frame. It is not an owner, route, page, flow, Registry, or generic Technical Role folder.

### 4.3. Navigation Hierarchy

Navigation is classified as:

```text
System (A)
Product (B)
Product Area (C)
Page (D)
Drill-down (E+)
```

A-class navigation belongs in Global Actions. B-class Products appear primarily in the persistent sidebar. The active Product exposes one supported C-class level. D-class and deeper destinations render in Main.

### 4.4. Core Navigation Host

`Navigation` is the required Core capability and Host for Product and Product Area navigation Contributions.

Target identity:

```text
app/Core/Navigation/
App\Core\Navigation\
navigation
Contrib/Navigation/
```

### 4.5. Surface Placement

Generic `Surface/` and `Surfaces/` production ownership paths are not required for the representative examples.

Presentation-specific PHP uses precise roles such as PageData, ViewModel, Presenter, Renderer, Data, Query, or Navigation only where justified.

## 5. Architecture Findings

The representative examples confirm that the target model provides:

- one owner for each material responsibility;
- one predictable target owner root;
- permitted dependency direction;
- clear package and namespace identities;
- explicit Host, Registry, and Contribution inversion;
- owner-local delivery and persistence;
- reusable UI independence;
- deterministic proof and future guardrail strategies.

No example requires:

- Core to depend on an optional Module;
- UI to depend on application implementation;
- shared or unowned persistence;
- a generic production dumping ground;
- an undeclared Module-to-Module dependency;
- a new source-of-truth owner.

## 6. Transitional Findings

These conditions require later migration or documentation reconciliation rather than architecture exceptions:

- required Core responsibilities currently located beneath `Modules/`;
- current `App\Modules\...` namespaces;
- parallel UI CSS and JavaScript trees;
- UI contracts referencing obsolete `App\Surfaces` vocabulary;
- existing Phase 2 through Phase 5 documents using the broad Surface model;
- stale Phase status and acceptance metadata;
- existing shell and navigation implementation paths that predate the final UI artifact contract.

## 7. Later-Owner Decisions

| Decision                                                              | Owner or later phase                               |
| --------------------------------------------------------------------- | -------------------------------------------------- |
| Exact Workspace switcher route, URL, session, and preference behavior | Workspace, Access, UX, and implementation planning |
| Final Tenant Administration Workspace qualification                   | Product and architecture review                    |
| Whether selected B-class Products also appear in the header           | Navigation and UI review                           |
| Exact Product and Product Area Contribution schema                    | Core Navigation Contract implementation            |
| Exact Navigation ordering, conflict, and fallback metadata            | Core Navigation Host                               |
| Exact UI-shell internal bundle paths and public Blade APIs            | UI standards and implementation                    |
| Detailed Settings and Projects schema                                 | Goal 6                                             |
| Physical current-to-target migration and compatibility                | Phase 7 and later migration issues                 |
| Guardrail implementation order and tooling                            | Later verification issues                          |

These decisions do not prevent ownership, dependency, or target-root validation.

## 8. Exceptions

No permanent structural exception is currently required.

Compatibility paths may remain temporarily only through explicit migration records, bounded allowlists, and removal conditions. Transitional placement must not become a target precedent.

## 9. Proposed Phase 6 Result

> The Goal 3 repository architecture is practical for the representative Settings, Projects, Modal and Dialog, and Sidebar Navigation examples.
> The model requires one bounded correction to Workspace, Frame Surface, and navigation terminology and one corresponding Core Navigation Host identity. With that correction, each example has a clear owner, target root, namespace or artifact identity, permitted dependencies, test location, documentation owner, preimplementation proof strategy, and enforceable guardrails.
> No permanent architecture exception or new source-of-truth owner is required.
> Final Phase 6 acceptance remains pending ADR-0008 resolution, repository-owner review, and end-of-Goal-3 documentation reconciliation.

## 10. Required Reconciliation

After the repository owner accepts the Phase 6 result:

- update the Goal 3 target architecture and Phase 6 index;
- update Issue #53 terminology and final acceptance record;
- reconcile ADR-0006 and accept or revise ADR-0008;
- reconcile Workspace architecture and applicable architecture indexes;
- replace the broad Surface Definition and affected Host, Registry, Contribution, placement, dependency, and naming references;
- update Navigation and UI-shell standards;
- preserve accepted history and mark superseded language explicitly;
- run documentation guardrails and link validation.

The exact existing-file change set should be reviewed immediately before reconciliation because shared documentation may have advanced.

## 11. Phase 7 Handoff

Phase 7 may proceed after final Phase 6 acceptance to:

- map coarse current-to-target migration direction;
- classify moves, namespace changes, package extraction, registration changes, UI bundle consolidation, and compatibility work;
- preserve required behavior through the Phase 6 proof requirements;
- record intentional temporary exceptions;
- separate migration order from target authority;
- complete final Goal 3 reconciliation and acceptance.

## 12. Review Questions

Repository-owner review should confirm:

1. whether ADR-0008 accurately captures the bounded correction;
2. whether `Navigation` is accepted as the Core Host identity;
3. whether no permanent structural exception is required;
4. whether the later-owner decisions are correctly deferred;
5. whether the twelve selected guardrails are appropriately bounded;
6. whether Phase 7 may begin after documentation reconciliation.

## 13. Related

- [Phase 6.1 Representative Example Selections](6-1-representative-example-selections.md)
- [Phase 6.2 Representative Example Mappings](6-2-representative-example-mappings.md)
- [Phase 6.3 Ownership Boundary Verification](6-3-ownership-boundary-verification.md)
- [Phase 6.4 Dependency Direction Verification](6-4-dependency-direction-verification.md)
- [Phase 6.5 Placement And Naming Verification](6-5-placement-and-naming-verification.md)
- [Phase 6.6 Preimplementation Proof Requirements](6-6-preimplementation-proof-requirements.md)
- [Phase 6.7 Architecture Guardrail Selection](6-7-architecture-guardrail-selection.md)
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md)
- [ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)

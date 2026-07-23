<!--
DOC-META
title: Phase 6 Durable Promotion Register
doc_type: matrix
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/durable-promotion-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_matrix.md
summary: Routes accepted Phase 6 validation, Workspace, Frame Surface, Core Navigation, proof, guardrail, reconciliation, and migration results to their durable owners.
-->

# Phase 6 Durable Promotion Register

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Use This Register For](#3-use-this-register-for)
- [4. Do Not Use This Register For](#4-do-not-use-this-register-for)
- [5. Source Documents](#5-source-documents)
- [6. Promotion Principles](#6-promotion-principles)
- [7. Promotion Register](#7-promotion-register)
- [8. Promotion Sequence](#8-promotion-sequence)
- [9. Closeout Interpretation](#9-closeout-interpretation)
- [10. Maintenance Notes](#10-maintenance-notes)
- [11. Related](#11-related)

## 1. Purpose

Route accepted Phase 6 results into the long-lived decision, architecture, Definition, UI-standard, verification, agent-guidance, and migration owners that must govern work after Goal 3.

The register prevents the representative validation package from remaining the sole authority for Workspace, Frame Surface, Core Navigation, proof, and guardrail requirements.

## 2. Status

- Register lifecycle: active
- Phase decision state: Phase 6.1 through 6.8 and Phase 6.90 accepted through repository-owner review
- Promotion state: canonical reconciliation applied by this closeout change set; repository validation and Issue #53 closeout remain pending
- Implementation state: no production implementation, migration, or guardrail tooling performed
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Downstream migration issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)

## 3. Use This Register For

Use this register to:

- identify one durable owner for each accepted Phase 6 result;
- distinguish create, amend, replace, cross-link, issue synchronization, validation, and migration actions;
- sequence the bounded ADR-0008 correction across affected documents;
- preserve accepted history while removing conflicting active terminology;
- route preimplementation proof and architecture guardrail requirements;
- separate durable documentation reconciliation from Phase 7 migration work.

## 4. Do Not Use This Register For

Do not use this register to:

- claim a destination has been updated or validated;
- implement Workspace switching, Core Navigation, UI-shell changes, or guardrail tooling;
- authorize physical file, namespace, package, route, asset, or schema migration;
- replace detailed Phase 6 rationale;
- create persistence or Product behavior decisions owned elsewhere;
- add `AGENTS.md` rules before the applicable canonical architecture or standard exists;
- mark Issue #53 or Goal 3 complete without repository checks and the required acceptance records.

## 5. Source Documents

- [Representative Example Selections](6-1-representative-example-selections.md)
- [Representative Example Mappings](6-2-representative-example-mappings.md)
- [Ownership Boundary Verification](6-3-ownership-boundary-verification.md)
- [Dependency Direction Verification](6-4-dependency-direction-verification.md)
- [Placement And Naming Verification](6-5-placement-and-naming-verification.md)
- [Preimplementation Proof Requirements](6-6-preimplementation-proof-requirements.md)
- [Architecture Guardrail Selection](6-7-architecture-guardrail-selection.md)
- [Model Acceptance And Corrections](6-8-model-acceptance-and-corrections.md)
- [Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md)
- [ADR-0008](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)

## 6. Promotion Principles

1. ADR-0008 owns the accepted cross-cutting decision and partial supersession rationale.
2. Durable architecture owns long-lived Workspace, Frame, Navigation, contribution, and repository structure.
3. Definitions own reusable concept meaning, not complete implementation rules.
4. UI standards own rendering, interaction, accessibility, responsive behavior, and shell composition.
5. Planning retains representative evidence, proof design, guardrail selection, migration handoff, and historical traceability.
6. One durable owner contains each complete rule; related documents summarize and link.
7. Promotion updates indexes, metadata, acceptance state, supersession notes, and affected references in the same reconciliation cycle.
8. Verification and migration remain separate. Documentation promotion is not proof that implementation follows the accepted target.

## 7. Promotion Register

| Promotion ID  | Source                              | Durable result                                                                                                                                                                                                         | Primary destination                                                                          | Additional synchronization                                                                                                                                 | Action                                                    | Later owner                              | Status   |
| ------------- | ----------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------- | ---------------------------------------- | -------- |
| `P6-DEC-01`   | 6.8; 6.90                           | Multiple available Workspaces, one active Workspace, narrow Frame Surfaces, A–E+ navigation hierarchy, and Global Administration as a Workspace                                                                        | `docs/01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md`                 | Update `docs/01-decisions/index.md`; record the exact partial supersession in ADR-0006                                                                     | Accept and activate ADR-0008; amend index and ADR-0006    | Architecture owner                       | reconciled  |
| `P6-ARCH-01`  | 6.3–6.5; 6.90                       | Canonical Workspace, Frame, Frame Surface, Product, Product Area, Page, and navigation-composition model                                                                                                               | `docs/03-architecture/workspace-navigation-and-frame-composition.md`                         | Route from Architecture Index, System Overview, Workspace Identity Model, and ADR-0008                                                                     | Create or activate architecture owner; add links          | Architecture owner                       | reconciled |
| `P6-ARCH-02`  | 6.90; ADR-0008                      | User Accounts may access multiple Workspaces; exactly one is active in a rendered context                                                                                                                              | `docs/03-architecture/workspace-identity-model.md`                                           | Update System Overview and applicable tenancy links without changing Tenant or Instance identity                                                           | Amend                                                     | Architecture owner                       | reconciled  |
| `P6-ARCH-03`  | 6.2–6.5                             | Core Navigation owns Product and Product Area Contracts, Registry, resolution, ordering, active state, and fallback                                                                                                    | `docs/03-architecture/repository-architecture.md`                                            | Record `app/Core/Navigation/`, `App\Core\Navigation\`, `navigation`, and owner-local `Contrib/Navigation/`; update Core planning identity where applicable | Amend architecture and planning identity references       | Architecture and Core planning owners    | reconciled  |
| `P6-ARCH-04`  | 6.3; 6.4; 6.90                      | Workspace supplies Product scope; Access and Module lifecycle provide authoritative inputs; UI renders normalized output                                                                                               | `docs/03-architecture/system-overview.md`                                                    | Cross-link Workspace Navigation And Frame Composition and Application Registration                                                                         | Amend high-level composition summary                      | Architecture owner                       | reconciled  |
| `P6-ARCH-05`  | 6.90; ADR-0008                      | Architecture routing includes the dedicated Workspace, Navigation, and Frame composition owner                                                                                                                         | `docs/03-architecture/index.md`                                                              | Update reading order and related links                                                                                                                     | Amend index                                               | Architecture owner                       | reconciled  |
| `P6-DEF-01`   | 6.1–6.5; 6.90                       | `Surface` is narrowed to named Frame Surface regions and no longer identifies owner-specific Pages, destinations, flows, or a generic Technical Role folder                                                            | `docs/07-planning/Definitions/Surfaces/Definition.md`                                        | Reconcile applicable Phase 2, Phase 4, Phase 5, repository architecture, and planning references                                                           | Replace conflicting definition and cross-links            | Definition and architecture owners       | reconciled  |
| `P6-DEF-02`   | 6.3; 6.4                            | Host, Registry, Extension Point, Contribution, and Contributor definitions retain ownership inversion but use Frame Surface terminology where presentation is referenced                                               | Applicable files beneath `docs/07-planning/Definitions/`                                     | Update Definitions Index only if routing changes; correct stale Surface wording without reopening accepted Host rules                                      | Amend affected definitions                                | Definition owners                        | reconciled  |
| `P6-UI-01`    | 6.1; 6.3; 6.90                      | Navigation hierarchy, Sidebar and Header Frame Surfaces, persistent B-level Product access, active C-level Product Areas, and D/E+ page-local navigation                                                               | `docs/02-standards/ui/patterns/navigation.md`                                                | Update `docs/02-standards/ui/components/ui-shell.md`; update layout terminology only where conflicting                                                     | Amend UI standards                                        | UI, navigation, and accessibility owners | reconciled  |
| `P6-PROOF-01` | 6.6                                 | Future work establishes protected characterization or exact expected-nonpass proof before production implementation and reruns the same accepted proof unchanged                                                       | `docs/02-standards/coding/Testing Standards.md` and applicable Feature Development Standards | Cross-link from verification and issue templates where separately accepted                                                                                 | Amend standards only where the durable rule is incomplete | Testing and feature-development owners   | reconciled  |
| `P6-ENF-01`   | 6.7                                 | Twelve bounded guardrails cover optional-Module isolation, UI independence, public boundaries, Registry inversion, package declarations, paths, Contributions, delivery, persistence, UI artifacts, and test discovery | Later repository architecture-test, registration-validation, UI-validation, and CI issues    | Update `AGENTS.md` only after canonical owners and enforcement behavior are separately accepted                                                            | Queue implementation; do not claim checks exist           | Verification and tooling owners          | queued   |
| `P6-PLAN-01`  | 6.1–6.8; 6.90                       | Goal 3 synthesis records accepted representative results, bounded correction, no permanent exception, and Phase 7 handoff                                                                                              | `docs/07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md`           | Update Goal 3 Index and Phase 6 Index; reconcile affected Phase 2–5 documents                                                                              | Amend planning synthesis and routing                      | Goal 3 planning owner                    | reconciled  |
| `P6-ISSUE-01` | Complete Phase 6 package            | Issue #53 records accepted examples, correction, Core Navigation identity, guardrails, later decisions, and final validation evidence                                                                                  | GitHub Issue #53                                                                             | Update parent Issue #19 only after accepted repository application and checks                                                                              | Update acceptance records                                 | Repository owner                         | pending  |
| `P6-MIG-01`   | 6.5; 6.8                            | Transitional Modules, namespaces, broad Surface paths, parallel UI assets, shell/navigation paths, and compatibility identifiers become Phase 7 inputs                                                                 | Phase 7 Issue #54 and its migration artifacts                                                | Cross-link Phase 5 compatibility register and Phase 6 proof requirements                                                                                   | Handoff; no migration in Phase 6                          | Phase 7 and bounded migration owners     | queued   |
| `P6-AGENT-01` | Promoted architecture and standards | Repository agents route future work to accepted Workspace, Navigation, Frame Surface, proof, and guardrail owners without duplicating full rules                                                                       | Root and applicable scoped `AGENTS.md` files                                                 | Apply only after canonical architecture and standards reconciliation                                                                                       | Queue agent-guidance update                               | Repository-owner agent-governance review | queued   |

Paths listed as destinations are promoted by the Phase 6 closeout change set unless a row remains explicitly queued. Repository checks and final Issue #53 acceptance remain separate evidence.

## 8. Promotion Sequence

Use this order:

1. apply repository-owner acceptance to ADR-0008 and record the partial ADR-0006 supersession;
2. create or activate Workspace Navigation And Frame Composition and update the Architecture Index;
3. reconcile Workspace Identity Model, System Overview, and Repository Architecture;
4. replace the broad Surface Definition and amend affected Definitions;
5. update Navigation Pattern and UI Shell standards;
6. reconcile Goal 3 synthesis, Phase 2–6 planning references, Phase 6 Index, and Issue #53;
7. route proof requirements into testing and feature-development standards only where incomplete;
8. retain guardrail rows as unimplemented requirements for separately accepted issues;
9. transfer physical migration and compatibility subjects to Phase 7;
10. update agent guidance only after durable owners are in place.

A failed documentation check is not authorization to weaken the accepted Phase 6 result.

## 9. Closeout Interpretation

This register is complete when:

- every accepted Phase 6 correction has one primary durable destination;
- every affected active document is updated, linked, or explicitly queued;
- ADR-0008 acceptance and ADR-0006 partial supersession are unambiguous;
- broad Surface wording no longer competes with Frame Surface;
- Core Navigation identity is consistent across planning and architecture;
- proof and guardrail requirements have named later owners;
- Phase 7 receives the exact migration and compatibility subjects;
- no row implies unexecuted implementation or validation.

Completing the register does not mean queued guardrails, migration, Workspace switching, or Navigation implementation exist.

## 10. Maintenance Notes

- Update a row only from verified repository or GitHub evidence.
- Preserve accepted Phase 6 history after durable promotion.
- Remove duplicated full authority from planning where practical while retaining traceability.
- Recheck shared-file content immediately before writable reconciliation.
- Record unresolved target conflicts rather than choosing a second canonical owner.
- Keep implementation, migration, proof execution, and documentation promotion as separate states.

## 11. Related

- [Phase 6 Representative Architecture Validation Index](index.md)
- [Model Acceptance And Corrections](6-8-model-acceptance-and-corrections.md)
- [Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 5 Durable Promotion Register](../phase-5/durable-promotion-register.md)
- [Architecture Index](../../../../../03-architecture/index.md)
- [Decisions Index](../../../../../01-decisions/index.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)

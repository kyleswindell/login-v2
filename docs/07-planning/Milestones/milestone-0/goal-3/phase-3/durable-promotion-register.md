<!--
DOC-META
title: Phase 3 Durable Promotion Register
doc_type: planning
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/durable-promotion-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records how each accepted Phase 3 decision is promoted to durable architecture or standards authority or explicitly assigned to a later Goal 3 phase.
-->

# Phase 3 Durable Promotion Register

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This register proves that every accepted Phase 3 decision is either:

- promoted to an existing or new durable repository owner;
- already covered by an accurate durable owner;
- explicitly assigned to a later Goal 3 phase;
- retained only as planning evidence where durable promotion is not required.

It prevents accepted topology rules from remaining solely inside Phase planning.

## 2. Status

- Register state: active
- Source decisions: 3.1 through 3.9
- Governing issue: [#50](https://github.com/kyleswindell/login-v2/issues/50)
- Placement consumer: [#51](https://github.com/kyleswindell/login-v2/issues/51)
- Naming consumer: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Final promotion and migration review: [#54](https://github.com/kyleswindell/login-v2/issues/54)

## 3. Promotion Classes

| Class          | Meaning                                                         |
| -------------- | --------------------------------------------------------------- |
| Architecture   | Durable system structure, ownership, topology, or boundary      |
| ADR            | Durable cross-cutting architectural decision and rationale      |
| Standard       | Mandatory implementation or repository rule                     |
| Definition     | Controlled vocabulary or semantic contract                      |
| Agent guidance | Concise persistent execution routing                            |
| Verification   | Automated or manual proof requirement                           |
| Planning-only  | Evidence or sequencing that should not become durable authority |

## 4. Accepted Promotion Register

| Source | Durable rule                                                                                                | Durable owner or target                                                                                           | Action                                                                               | Timing / issue                                | Status                                      |
| ------ | ----------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ | --------------------------------------------- | ------------------------------------------- |
| 3.1    | Permanent repository roots, bounded purpose, generated roots, and acceptance qualification                  | `docs/03-architecture/repository-architecture.md`                                                                 | Promote architecture                                                                 | Phase 3 / #50                                 | promoted by this closeout package           |
| 3.2    | Core and UI owner roots; restricted Laravel integration roots; no peer Technical Role owners                | ADR-0005, current coding standards, and `repository-architecture.md`                                              | Retain existing ownership authority and add physical topology                        | Phase 3 / #50                                 | promoted                                    |
| 3.3    | `Http`, `Console`, and `Providers` are restricted global integration; conventional roles remain owner-local | `repository-architecture.md`; detailed placement standards                                                        | Promote topology; assign exact placement                                             | Phase 4 Decisions 4.2, 4.3, and 4.8 / #51     | architecture promoted; detail assigned      |
| 3.4    | Sparse `app/Core/<Capability>/<TechnicalRole>/` structure and no generic Core layers                        | `repository-architecture.md`; future placement and naming standards                                               | Promote structure; assign exact paths and names                                      | Phase 4 / #51 and Phase 5 / #52               | architecture promoted; detail assigned      |
| 3.5    | Optional distributable Composer package structure beneath `Modules/`                                        | `repository-architecture.md`; future Module placement, Composer, namespace, registration, and generator standards | Promote package pattern; assign exact rules                                          | Phase 4 / #51 and Phase 5 / #52               | architecture promoted; detail assigned      |
| 3.6    | Artifact-owned presentation bundles and primary Vite composition entrypoints                                | `repository-architecture.md`; existing UI standards; future placement and naming updates                          | Promote bundle architecture; assign detailed paths, registration, and names          | Phase 4 Decision 4.7 / #51 and Phase 5 / #52  | architecture promoted; detail assigned      |
| 3.7    | Bounded supporting-branch responsibilities                                                                  | `repository-architecture.md` and existing specialist standards                                                    | Promote architecture; retain specialist policy owners                                | Phase 3 / #50                                 | promoted                                    |
| 3.8    | Transitional, compatibility-only, and prohibited branches; removal gate                                     | `repository-architecture.md`, existing root/scoped `AGENTS.md`, future enforcement list                           | Promote architecture; verify agent guidance; assign static enforcement candidates    | Phase 3 / #50 and Phase 4 Decision 4.12 / #51 | architecture promoted; enforcement assigned |
| 3.9    | Owner-local tests plus repository-wide root suites                                                          | `repository-architecture.md`, `docs/02-standards/ui/testing.md`, and future general testing updates               | Retain durable UI coverage; promote general topology; assign deterministic discovery | Phase 4 Decision 4.8 / #51                    | topology promoted; discovery assigned       |

## 5. Existing Durable Coverage Confirmed

The repository already contains durable ownership and classification rules in:

- `docs/01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md`;
- `docs/01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md`;
- `docs/02-standards/coding/Coding Standards.md`;
- `docs/02-standards/coding/Feature Development Standards.md`;
- `docs/02-standards/coding/File Archetypes.md`;
- `docs/02-standards/coding/File Building Standards.md`;
- `docs/02-standards/coding/Application Actions Services And Data Objects Standards.md`;
- `docs/02-standards/coding/Code Template And Generator Standards.md`;
- `docs/02-standards/coding/Agent Implementation Checklist.md`;
- `docs/02-standards/ui/testing.md`.

These documents already establish owner-first classification, Core and Module ownership, Technical Roles beneath owners, transitional `app/Platform` status, Surface and Registry boundaries, and UI-local test placement.

Phase 3 therefore does not create a competing broad repository-organization standard.

## 6. Agent-Guidance Review

The Phase 3 closeout scan found active transitional-path references only in:

- root `AGENTS.md`;
- `docs/02-standards/database/AGENTS.md`;
- `stubs/AGENTS.md`.

Each reference correctly states that `app/Platform` is transitional, is not a target owner, or must not receive new canonical work.

No active agent instruction was found directing new work into:

```text
app/Surfaces/
app/Support/
app/Models/
app/Rules/
app/Livewire/
Modules/_Template/
resources/views/platform/
resources/views/livewire/platform/
resources/css/components/
resources/css/patterns/
resources/css/tokens/
resources/css/type/
resources/css/ui/
resources/js/ui-controls/
resources/js/internal/
```

Result:

- broad `AGENTS.md` rewriting is not required for Phase 3 closeout;
- later scoped changes must preserve the current restrictions;
- future static enforcement candidates remain Phase 4 Decision 4.12 authority.

## 7. Explicit Phase 4 Assignments

Issue #51 must decide and promote durable rules for:

- contract placement;
- implementation placement;
- Delivery Adapter placement;
- Core and Module route placement and registration;
- configuration placement;
- database and migration placement;
- exact view and asset placement;
- Core, Module, UI, integration, browser, and root test placement and discovery;
- documentation placement;
- dependency direction;
- cross-owner communication;
- placement and dependency exceptions;
- later static checks and tests.

Expected durable updates include existing coding, database, UI, testing, documentation, and agent standards rather than unnecessary duplicate standards.

## 8. Explicit Phase 5 Assignments

Issue #52 must decide and promote naming rules for:

- folders and namespaces;
- Core capabilities and Modules;
- contracts and implementations;
- Delivery Adapters;
- routes and configuration;
- events, jobs, tests, fixtures, and documentation;
- Module package metadata and definition naming;
- UI bundle files, category aggregators, internal folders, and import conventions;
- compatibility aliases and rename behavior.

## 9. Phase 7 Review Assignment

Issue #54 must verify that:

- all Phase 4 and Phase 5 promotion assignments were completed or explicitly transferred;
- migration direction identifies every transitional structure;
- compatibility exceptions have owners and removal conditions;
- durable architecture and standards agree;
- planning is not the sole owner of an accepted mandatory rule.

## 10. Completion Result

The Phase 3 durable-promotion requirement is satisfied when:

- `docs/03-architecture/repository-architecture.md` is installed;
- `docs/03-architecture/index.md` routes to it;
- `docs/03-architecture/system-overview.md` routes to it;
- this register is installed and routed from the Phase 3 index;
- the architecture and standards assignments above remain recorded;
- required documentation validation passes;
- the repository owner accepts the Phase 3 closeout.

## 11. Related

- [Phase 3 Index](index.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
- GitHub Phase 3 issue: [#50](https://github.com/kyleswindell/login-v2/issues/50)
- GitHub Phase 4 issue: [#51](https://github.com/kyleswindell/login-v2/issues/51)
- GitHub Phase 5 issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)

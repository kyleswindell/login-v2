<!--
DOC-META
title: Phase 4.8 Test Placement
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-8-test-placement.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the hybrid owner-local and repository-wide test-placement model plus deterministic discovery requirements.
-->

# Phase 4.8 Test Placement

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define where tests belong without designing the complete verification strategy.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: accepted Phase 3 test topology

## 3. Default Placement

| Test owner                                  | Default placement                    |
| ------------------------------------------- | ------------------------------------ |
| Core capability                             | `app/Core/<Capability>/__tests__/`   |
| Reusable UI PHP/runtime                     | `app/UI/<Responsibility>/__tests__/` |
| UI presentation artifact                    | Owning artifact bundle `__tests__/`  |
| Module package                              | `Modules/<Module>/tests/`            |
| Application-wide HTTP integration           | `app/Http/__tests__/`                |
| Application-wide console integration        | `app/Console/__tests__/`             |
| Application-wide provider integration       | `app/Providers/__tests__/`           |
| Cross-owner or repository-wide verification | Root `tests/`                        |

Owner-local test folders may use sparse `Unit`, `Feature`, `Contracts`, `Architecture`, `Fixtures`, or `Support` subdivisions only when needed.

## 4. Root Test Scope

Repository-root `tests/` remains for:

- cross-owner integration;
- system and browser behavior;
- architecture and dependency rules;
- compatibility;
- repository validation;
- shared test infrastructure;
- tests with no single responsible owner.

## 5. Discovery And Movement

The registration and verification system must deterministically discover every accepted test location in local and CI execution.

Physical movement is prohibited until the same targeted proof passes unchanged from the new location.

The following are failures:

- silent test disappearance;
- duplicate execution;
- skipped discovery;
- production loading of test code;
- weakening, deleting, or materially rewriting accepted tests or fixtures without accepted contract revision.

## 6. Accepted Decision

> Login 2.0 places tests with the smallest cohesive owner or presentation artifact they verify. Core capability tests live beneath `app/Core/<Capability>/__tests__/`; reusable UI PHP and runtime tests live beneath `app/UI/<Responsibility>/__tests__/`; UI artifact tests remain colocated beneath the owning presentation bundle; and Module tests remain package-local beneath `Modules/<Module>/tests/`. Application-wide Laravel integration tests may live beneath the applicable restricted `app/Http/`, `app/Console/`, or `app/Providers/` integration branch.
>
> Repository-root `tests/` is reserved for cross-owner integration, system and browser behavior, architecture and dependency rules, compatibility, repository validation, and shared test infrastructure. Test folders remain sparse and use subordinate categories only when needed.
>
> The registration and verification system must deterministically discover every accepted test location locally and in CI. Physical test movement is prohibited until the same targeted proof passes unchanged from the new location. Silent omission, duplicate execution, production loading, and weakening of accepted tests or fixtures are prohibited. Phase 4 defines placement and ownership only.

## 7. Boundaries And Handoff

Phase 4 does not define the complete verification architecture, suite commands, coverage policy, browser matrix, or specialist review requirements. Phase 5 owns final suite and fixture naming.

## 8. Related

- [View And Asset Placement](4-7-view-and-asset-placement.md)
- [Dependency Direction](4-10-dependency-direction.md)
- [Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: #51

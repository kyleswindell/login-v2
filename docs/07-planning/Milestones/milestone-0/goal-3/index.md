<!--
DOC-META
title: Goal 3 Target Repository Architecture Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/index.md
parent: docs/07-planning/Milestones/milestone-0/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the Goal 3 target-repository-architecture synthesis, Phase packages, accepted results, and downstream Goal 3 reading.
-->

# Goal 3 Target Repository Architecture Index

Parent: [Milestone 0 Planning Index](../index.md)

Use this index to navigate the Goal 3 synthesis artifact, accepted Phase results, and detailed Phase planning.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Goal Status](#3-goal-status)
- [4. Goal Documents](#4-goal-documents)
- [5. Phase Register](#5-phase-register)
- [6. Reading Order](#6-reading-order)
- [7. Maintenance Notes](#7-maintenance-notes)
- [8. Related](#8-related)

## 1. Purpose

Goal 3 defines and accepts the target repository architecture for Login 2.0.

It establishes:

- application ownership boundaries;
- primary repository organization;
- target repository topology;
- artifact placement;
- dependency direction;
- naming conventions;
- representative validation;
- high-level migration and compatibility direction.

This index routes readers to the cumulative Goal 3 synthesis and the detailed Phase packages that support it.

## 2. Scope

### 2.1. Belongs Here

This folder owns Goal 3 planning for:

- Core, Module, and UI ownership boundaries;
- Surface, Host Registry, Contribution, Delivery Adapter, and Laravel integration responsibilities;
- repository organization and topology;
- artifact placement and dependencies;
- repository naming;
- representative architecture validation;
- migration direction;
- compatibility and structural exceptions;
- final Goal 3 acceptance.

### 2.2. Does Not Belong Here

This folder does not own:

- physical repository migration;
- implementation of compatibility adapters;
- detailed database schemas;
- contract discovery or export tooling;
- the complete verification architecture;
- implementation code;
- active delivery state outside the governing GitHub issues.

Those concerns belong to later Goals, bounded implementation issues, or their applicable canonical owners.

## 3. Goal Status

- Planning lifecycle: active
- Acceptance state: Phases 1 through 4 accepted; Phase 5 decisions and package accepted with canonical promotion under final validation; Phases 6 and 7 pending
- Owning GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Current active Phase issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Next Phase issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Final acceptance: pending completion of all seven Phases and repository-owner review

## 4. Goal Documents

| Document                                                            | Document type | Purpose                                                                                                   | Status |
| ------------------------------------------------------------------- | ------------- | --------------------------------------------------------------------------------------------------------- | ------ |
| [Target Repository Architecture](target-repository-architecture.md) | planning      | Consolidates the accepted high-level result of each Goal 3 Phase and routes readers to detailed planning. | active |

The synthesis remains a planning document while Goal 3 is active. Durable rules are promoted later to architecture, standards, definitions, agent guidance, and verification owners.

## 5. Phase Register

| Phase | Subject                                  | Issue                                                     | State                                                                  | Detailed planning                 |
| ----- | ---------------------------------------- | --------------------------------------------------------- | ---------------------------------------------------------------------- | --------------------------------- |
| 1     | Architecture boundaries                  | [#48](https://github.com/kyleswindell/login-v2/issues/48) | accepted                                                               | [Phase 1 Index](phase-1/index.md) |
| 2     | Repository organization                  | [#49](https://github.com/kyleswindell/login-v2/issues/49) | accepted                                                               | [Phase 2 Index](phase-2/index.md) |
| 3     | Target repository tree                   | [#50](https://github.com/kyleswindell/login-v2/issues/50) | accepted                                                               | [Phase 3 Index](phase-3/index.md) |
| 4     | Placement and dependency rules           | [#51](https://github.com/kyleswindell/login-v2/issues/51) | accepted                                                               | [Phase 4 Index](phase-4/index.md) |
| 5     | Naming conventions                       | [#52](https://github.com/kyleswindell/login-v2/issues/52) | decisions and package accepted; canonical promotion validation pending | [Phase 5 Index](phase-5/index.md) |
| 6     | Representative validation                | [#53](https://github.com/kyleswindell/login-v2/issues/53) | pending                                                                | Phase package not yet created     |
| 7     | Migration direction and final acceptance | [#54](https://github.com/kyleswindell/login-v2/issues/54) | pending                                                                | Phase package not yet created     |

## 6. Reading Order

For Goal 3 work:

1. read [Target Repository Architecture](target-repository-architecture.md) for the accepted cumulative model;
2. open the applicable Phase index;
3. open only the specific decision or planning document needed for the current question;
4. verify the applicable GitHub issue before writable work;
5. do not reopen accepted prior-Phase decisions without an explicitly authorized corrective amendment.

For current Phase 5 review:

1. read the [Phase 5 Index](phase-5/index.md);
2. use its naming, role, Module identity, compatibility, and promotion matrices;
3. read the applicable Decision 5.1–5.14 document;
4. use the synthesis artifact only for the concise accumulated result;
5. use Phase 6 for representative proof rather than reopening accepted naming rules.

## 7. Maintenance Notes

- Keep this index routing focused.
- Keep the target-architecture synthesis concise and cumulative.
- Add Phase folders only when their index and planning documents exist.
- Update the Phase register when acceptance state changes.
- Do not duplicate detailed Phase decision analysis here.
- Ensure corrective amendments are reflected in the synthesis and linked from affected Phase indexes.
- Promote durable Goal 3 results according to each accepted Phase promotion register; do not wait until Phase 7 when a durable owner is already established.
- Remove or redirect obsolete duplicate Goal 3 synthesis locations after inbound links are updated.
- Do not use this index as an active task board.

## 8. Related

- [Milestone 0 Planning Index](../index.md)
- [Target Repository Architecture](target-repository-architecture.md)
- [Phase 1 Index](phase-1/index.md)
- [Phase 2 Index](phase-2/index.md)
- [Phase 3 Index](phase-3/index.md)
- [Phase 4 Index](phase-4/index.md)
- [Phase 4 Artifact Placement Matrix](phase-4/artifact-placement-matrix.md)
- [Phase 4 Dependency And Communication Matrix](phase-4/dependency-and-communication-matrix.md)
- [Phase 4 Durable Promotion Register](phase-4/durable-promotion-register.md)
- [Phase 5 Naming Conventions Index](phase-5/index.md)
- [Phase 5 Naming Convention Matrix](phase-5/naming-convention-matrix.md)
- [Phase 5 Durable Promotion Register](phase-5/durable-promotion-register.md)
- GitHub parent issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Current Phase issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Next Phase issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)

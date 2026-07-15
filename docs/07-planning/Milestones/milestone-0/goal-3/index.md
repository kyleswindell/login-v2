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
summary: Routes the Goal 3 target-repository-architecture consolidation plan, Phase packages, accepted results, and downstream Goal 3 reading.
-->

# Goal 3 Target Repository Architecture Index

Parent: [Milestone 0 Planning Index](../index.md)

Use this index to navigate Goal 3 planning, accepted Phase results, and the consolidated target-repository-architecture plan.

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
- the primary repository organization;
- the target repository tree;
- artifact placement;
- dependency direction;
- naming conventions;
- representative validation;
- high-level migration and compatibility direction.

This index routes readers to the concise Goal 3 consolidation plan and the detailed Phase packages that support it.

## 2. Scope

### 2.1. Belongs Here

This folder owns Goal 3 planning for:

- Core, Module, and UI ownership boundaries; Laravel integration boundaries; and Surface, Delivery Adapter, and Host Registry technical responsibilities;
- repository organization;
- repository topology;
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
- full verification architecture;
- active issue status;
- implementation code.

Those concerns belong to later Goals, bounded implementation issues, or their applicable canonical owners.

## 3. Goal Status

- Planning lifecycle: active
- Acceptance state: Phase 1 accepted; Phase 2 decisions resolved with formal closeout pending; Phases 3 through 7 pending
- Owning GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Current active Phase issue: [#49](https://github.com/kyleswindell/login-v2/issues/49)
- Final acceptance: pending completion of all seven Phases and repository-owner review

## 4. Goal Documents

| Document                                                            | Purpose                                                                                                   | Status |
| ------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------- | ------ |
| [Target Repository Architecture](target-repository-architecture.md) | Consolidates the accepted high-level result of each Goal 3 Phase and routes readers to detailed planning. | active |

## 5. Phase Register

| Phase | Subject                                  | Issue                                                     | State                      | Detailed Planning                 |
| ----- | ---------------------------------------- | --------------------------------------------------------- | -------------------------- | --------------------------------- |
| 1     | Architecture boundaries                  | [#48](https://github.com/kyleswindell/login-v2/issues/48) | accepted                   | [Phase 1 Index](phase-1/index.md) |
| 2     | Repository organization                  | [#49](https://github.com/kyleswindell/login-v2/issues/49) | resolved; closeout pending | [Phase 2 Index](phase-2/index.md) |
| 3     | Target repository tree                   | [#50](https://github.com/kyleswindell/login-v2/issues/50) | pending                    | Phase package not yet created     |
| 4     | Placement and dependency rules           | [#51](https://github.com/kyleswindell/login-v2/issues/51) | pending                    | Phase package not yet created     |
| 5     | Naming conventions                       | [#52](https://github.com/kyleswindell/login-v2/issues/52) | pending                    | Phase package not yet created     |
| 6     | Representative validation                | [#53](https://github.com/kyleswindell/login-v2/issues/53) | pending                    | Phase package not yet created     |
| 7     | Migration direction and final acceptance | [#54](https://github.com/kyleswindell/login-v2/issues/54) | pending                    | Phase package not yet created     |

## 6. Reading Order

For Goal 3 work:

1. read [Target Repository Architecture](target-repository-architecture.md) for the accepted high-level model;
2. open the applicable Phase index;
3. open the specific decision or planning document needed for the current question;
4. verify the applicable GitHub issue before writable work;
5. do not reopen accepted prior-Phase decisions unless an explicit corrective amendment is authorized.

## 7. Maintenance Notes

- Keep this index routing focused.
- Keep the target-architecture plan concise and synthesis focused.
- Add Phase folders only when their index and planning documents exist.
- Update the Phase register when acceptance state changes.
- Do not duplicate detailed Phase decision analysis here.
- Ensure corrective amendments are reflected in the target-architecture plan and linked from the affected Phase indexes.
- Promote durable Goal 3 results to their final canonical owners during or after Phase 7.
- Do not use this index as an active task board.

## 8. Related

- [Milestone 0 Planning Index](../index.md)
- [Target Repository Architecture](target-repository-architecture.md)
- [Phase 1 Index](phase-1/index.md)
- [Phase 2 Index](phase-2/index.md)
- GitHub parent issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)

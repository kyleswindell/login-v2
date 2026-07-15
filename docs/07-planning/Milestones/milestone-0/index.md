<!--
DOC-META
title: Milestone 0 Planning Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/index.md
parent: docs/07-planning/Milestones/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the Milestone 0 repository-convergence charter, active goal packages, accepted planning results, and milestone-level documentation relationships.
-->

# Milestone 0 Planning Index

Parent: [Milestones Index](../index.md)

Use this index to navigate the Milestone 0 planning package and its Goal-specific planning folders.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Milestone Status](#3-milestone-status)
- [4. Milestone Documents](#4-milestone-documents)
- [5. Goal Packages](#5-goal-packages)
- [6. Reading Order](#6-reading-order)
- [7. Maintenance Notes](#7-maintenance-notes)
- [8. Related](#8-related)

## 1. Purpose

Milestone 0 establishes the repository-convergence decisions and evidence required before later implementation milestones can proceed without rediscovering ownership, architecture, contracts, persistent-data direction, standards, migration rules, or verification authority.

This index routes:

- the Milestone 0 charter;
- Goal-specific planning packages;
- accepted and active Goal results;
- milestone-level dependencies and downstream reading.

GitHub issues remain the source of current delivery status and bounded acceptance work.

## 2. Scope

### 2.1. Belongs Here

This folder owns navigation for:

- Milestone 0 planning;
- Milestone 0 Goal packages;
- Goal-level indexes and consolidation artifacts;
- milestone-wide planning relationships;
- links to current canonical milestone control documents.

### 2.2. Does Not Belong Here

This folder does not own:

- active task-board status;
- pull-request or commit evidence;
- implemented architecture truth;
- enforceable standards;
- detailed feature behavior;
- database contracts;
- operational procedures;
- agent execution workflows.

Those concerns remain with GitHub or their applicable canonical documentation branches.

## 3. Milestone Status

- Planning lifecycle: active
- GitHub milestone: M0 Planning Consolidation
- Milestone charter: active
- Goal 1: accepted and closed
- Goal 2: closed in GitHub; its issue-body acceptance record still requires documentation reconciliation
- Goal 3: active
- Goals 4 through 10: governed by the Milestone 0 charter and added here when their folder packages are created

## 4. Milestone Documents

| Document                                                                                      | Purpose                                                                                                           | Status |
| --------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- | ------ |
| [M0 Repository Convergence Planning](../../00-overview/m0-repository-convergence-planning.md) | Defines the Milestone 0 charter, ten Goal workstreams, dependencies, required artifacts, and final exit criteria. | active |

## 5. Goal Packages

| Goal   | Purpose                                                                                                        | GitHub Issue                                              | Planning Package                |
| ------ | -------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------- | ------------------------------- |
| Goal 1 | Canonical vocabulary and ownership                                                                             | [#17](https://github.com/kyleswindell/login-v2/issues/17) | [Goal 1 Index](goal-1/index.md) |
| Goal 2 | Current-state inventory and disposition                                                                        | [#18](https://github.com/kyleswindell/login-v2/issues/18) | [Goal 2 Index](goal-2/index.md) |
| Goal 3 | Target repository architecture, topology, placement, dependencies, naming, validation, and migration direction | [#19](https://github.com/kyleswindell/login-v2/issues/19) | [Goal 3 Index](goal-3/index.md) |

Goal packages for Goals 4 through 10 should be added when their planning folders are created. The Milestone 0 charter remains the routing authority for the complete ten-Goal sequence.

## 6. Reading Order

For Milestone 0 work:

1. read the [M0 Repository Convergence Planning](../../00-overview/m0-repository-convergence-planning.md) charter;
2. open the applicable Goal index;
3. read the Goal consolidation artifact when one exists;
4. open only the Phase, decision, inventory, or planning document required for the current task;
5. verify current issue scope and status in GitHub before writable work.

## 7. Maintenance Notes

- Keep this index concise and routing focused.
- Add a Goal package only when its folder and index exist.
- Do not duplicate Goal-level planning content here.
- Keep GitHub issue links aligned with the applicable Goal packages.
- Update lifecycle descriptions when Goal acceptance or documentation status changes.
- Route durable results to architecture, standards, features, database, runbooks, or other canonical owners when promotion occurs.
- Do not use this index as an active task board.

## 8. Related

- [Milestones Index](../index.md)
- [Planning Index](../../index.md)
- [M0 Repository Convergence Planning](../../00-overview/m0-repository-convergence-planning.md)
- [Goal 3 Index](goal-3/index.md)
